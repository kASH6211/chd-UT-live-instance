<?php

namespace App\Jobs;

use App\Models\HrmsOffice;
use App\Models\PayScale;
use App\Models\PollingData;
use App\Models\PollingDataPhoto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\Bank;


class HRMSPollingDataImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $hrmsdesignations=[];
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        set_time_limit(10000);
        $employees=DB::table('hrms_polling_data')->get();
       
        
        $this->addEmployees($employees);
       
    }

    public function addEmployees($employees)
    {
        
      
       
       
        
        $this->hrmsdesignations=DB::table('hrms_designations')->get()->pluck('dise_desigcode', 'hrms_desigcode')->toArray(); //in import
        
        $employees->each(function ($row){
           
            if($row->CLASS <> 4)
            {
                
                $poldata=PollingData::withTrashed()->where('hrmsdata',1)->where('hrmscode',$row->HRMSCODE)->first();
                $office=HrmsOffice::where('hrms_officecode',$row->OFFICECODE)->first();
                $distcode=$office->distcode;
                $deptcode=$office->deptcode;
                $officecode=$office->officecode;
                $deptslno=$this->createDeptslnoCode($distcode,$deptcode,$officecode);
                if($distcode!=-1 and $distcode!=null and $deptcode!=null and $officecode!=null and $officecode!=null and $deptslno!=null)
                {
                
                    if($poldata)
                    {
                        $poldata->restore();
                        if($poldata->distcode!=$distcode or $poldata->deptcode!=$deptcode or $poldata->officecode!=$officecode )
                        {
                            $poldata->distcode=$distcode;
                            $poldata->deptcode=$deptcode;
                            $poldata->officecode=$officecode;
                            $poldata->deptslno=$deptslno;
                            $phid = $this->generatePhotoId($distcode,$deptcode,$officecode,$deptslno);
                            $polldataphoto=PollingDataPhoto::where('id',$poldata->photoid)->first();
                            $poldata->photoid=$phid;
                            $poldata->completed='0';
                            $poldata->office='';
                            $poldata->cons=null;
                            $poldata->transferred='T';
                            if($polldataphoto)
                            {
                                $obj= new PollingDataPhoto();
                                $obj->empphoto=$polldataphoto->empphoto;
                                $polldataphoto->delete();
                                $poldata->save();
                                $obj->id=$phid;
                                $obj->save();
                            }
                    }

                    $poldata->DesigCode=intval($row->DESIGCODE)>0?$this->getDesignationCode($row->DESIGCODE):null;
                    $poldata->PayScaleCode=($row->PAYLEVEL=='NULL' or $row->PAYLEVEL=='')?null:($this->getPayScaleCode($distcode,$row->PAYLEVEL));
                    $poldata->BankId=$this->getBankId($row->BANKNAME);
                    $poldata->save();
                }
                else
                {
                    $basicpay = null;
                    $category =  null;
                    if($row->BASICPAY!="NULL")
                    {
                        $basicpay = intval($row->BASICPAY);
                    }
                    if($row->CLASS!="NULL")
                    {
                        if($row->CLASS==1)
                        {
                            $category = "A";
                        }
                        elseif($row->CLASS==2)
                        {
                            $category = "B";
                        }
                        else
                        {
                            $category = "C";

                        }
                    }
                    DB::table('polling_data')->insert([
                        'distcode' => $distcode,
                        'deptcode' => $deptcode ,
                        'officecode' => $officecode,
                        'photoid' => $this->generatePhotoId($distcode,$deptcode,$officecode,$deptslno),
                        'Name' => $row->NAME,
                        'FName' => $row->FATHER_HUSBAND,
                        'hrmscode'=>$row->HRMSCODE,
                        'EmpTypeId'=>1,
                        'mobileno'=>$row->MOBILE,
                        'sex'=>substr($row->GENDER,0,1),
                        'dob'=>$row->DOB,
                        'deptslno'=>$deptslno,
                        'category'=>$category,
                        'emailid'=>$row->EMAIL,
                        'basicPay'=>$basicpay,
                        // 'dob'=>$dob,
                        'retiredt'=>$row->DOR,
                        'PayScaleCode'=>($row->PAYLEVEL=='NULL' or $row->PAYLEVEL=='')?null:($this->getPayScaleCode($distcode,$row->PAYLEVEL)),
                        'BankId'=>$this->getBankId($row->BANKNAME),
                        'IfscCode'=>$row->IFSCCODE,
                        'BankAcNo'=>$row->ACCOUNTNO,
                        'del'=>'o',
                        'hrmsdata'=>1,
                        'DesigCode'=>$this->getDesignationCode($row->DISTCODE),
                        'created_at'=>now(),
                        'updated_at'=>now()
                                    // ... Map columns from your Excel file to the table
                        ]);
               
                    }
                }
            }
         });
      
        PollingData::onlyTrashed()->forceDelete();
        session()->flash('success', 'Data imported and table created successfully.');
    }

    public function createDeptslnoCode($distcode,$deptcode,$officecode)
    {
       
       $code =1;
       
       $t1=now();
        $employee= PollingData::withTrashed()->where('distcode',$distcode)->where('deptcode',$deptcode)->where('officecode',$officecode)->where('hrmsdata',1)->get();
        //dd();
        
        if($employee->first() )
        {
            $max=-1;
            foreach($employee as $emp)
            {
            if($emp->deptslno>$max)
            $max=$emp->deptslno;
            }
          $code=$max+1 ;
        
        }

       
        
        
        return $code;
    }
    public function generatePhotoId($distcode,$deptcode,$officecode,$deptslno)
    {
        if($distcode<10)
            $distcode = '0'.$distcode;
       
        $deptslno = $this->addPadding($deptslno);
        $temp=$distcode.$deptcode.$officecode.$deptslno;
        return $temp;

    }
    public function addPadding($code)
    {
       $code = intval($code);
        if($code<10)
            return '000'.$code;
        else if($code>=10 && $code<100)
            return '00'.$code;
        else if($code>=100 && $code<1000)
            return '0'.$code;
        
            return $code;
    }
    public function getDesignationCode($hrms_desig)
    {
        $desig= $this->hrmsdesignations[$hrms_desig];//in getdesignation
        if($desig)
        { 
            return $desig;
        }
        return null;
    }
    public function getPayScaleCode($distcode,$payscale)
    {

       $pay=PayScale::where('distcode',$distcode)->where('PayScale',$payscale)->first();
       if($pay)
        return $pay->PayScaleCode;
      
       $payscale_code=1;
       $pay=PayScale::where('distcode',$distcode)->orderBy('PayScaleCode','DESC')->first();
      
        if($pay)
        $payscale_code=$pay->PayScaleCode+1;
    
        PayScale::create(['distcode'=>$distcode,'PayScaleCode'=>$payscale_code,'PayScale'=>$payscale,'class'=>3]);
       
     return $payscale_code;

     }
     public function getBankId($bankname)
     {
        $bank=Bank::where('BankName',$bankname)->first();
        if($bank)
         return $bank->BankId;
       $bank_id=1;
        $bank=Bank::orderBy('BankId','DESC')->first();
         if($bank)
           $bank_id=$bank->BankId+1;
      Bank::create(['BankId'=>$bank_id,'BankName'=>$bankname]);
      return $bank_id;
     }

}
