<?php

namespace App\Http\Livewire\Import\Hrms;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use App\Imports\ExcelImports\DepartmentImport;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use App\Models\DistMaster;
use Illuminate\Support\Facades\Auth;
use App\Models\DeptMaster;
use App\Models\Bank;
use App\Models\PayScale;
use App\Models\PollingData;
use DB;

class EmployeeData extends Component
{
    use WithFileUploads;
    public $count=0;
    public $file;
    public $exectime;
    public $tableName ="hrms_employees";
    public $distcodelist=[];

    public function mount()
    {
        $this->distcodelist = DistMaster::get('id');
    }
   
    public function render()
    {
        return view('livewire.import.hrms.employee-data');
    }
    public function createDeptslnoCode($distcode,$deptcode,$officecode)
    {
       //$offset = 5000;
       $code =1;
        $employee= PollingData::where('distcode',$distcode)->where('deptcode',$deptcode)->where('officecode',$officecode)->where('hrmsdata',1)->orderBy('id','DESC')->first();
        
       
        
        if($employee && $employee->deptslno!=null){
         $code=($employee->deptslno+1);}
        
        return $code;
        
        
        
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

    public function generatePhotoId($distcode,$deptcode,$officecode,$deptslno)
    {
        if($distcode<10)
            $distcode = '0'.$distcode;
       
        $deptslno = $this->addPadding($deptslno);
        $temp=$distcode.$deptcode.$officecode.$deptslno;
        return $temp;

    }

    public function getDesignationCode($hrms_desig)
    {
        $desig= DB::table('hrms_designations')->where('hrms_desigcode',$hrms_desig)->first();
        if($desig)
        { 
            return $desig->dise_desigcode;
        }
        return null;
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
   
    


    public function import()
    {
       // dd(Str::limit("GOVT SEN SEC SCHOOL BOYS FATEHGAR CHURIAN PIN:143602", 50));
        set_time_limit(600);
        $strttime=microtime(true);
        //dd($this->createOfficeCode('609','5001'));
        //$this->getDiseDistCode('609');
        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);
        
        // Store the uploaded Excel file
        $path = $this->file->store('temp');
       
        // Import data from the Excel file using your custom import class
        $employees = Excel::toCollection(new DepartmentImport, $path);
      
        $employees = $employees[0];
        
        if(Schema::hasTable($this->tableName))
        {
            Schema::dropIfExists($this->tableName);
        }
        

        Schema::create($this->tableName, function ($table) {
            $table->id();
            // $table->string('hrms_distcode');
            // $table->integer('distcode')->nullable();
            // $table->string('hrms_deptcode');
            // $table->string('deptcode')->nullable();
            // $table->string('hrms_officecode');
            // $table->string('officecode')->nullable();
            // $table->string('officename');
            //$table->string('officeaddress');


            
            
            // ... Define table columns based on your data
            $table->timestamps();
        });
        // Create a new table in the database if it does not exist
        DB::table('polling_data')->where('distcode',Auth::User()->distcode)->where('hrmsdata',1)->delete();
        // Insert data into the newly created table
        $employees->each(function ($row) {
            if($row[9] <> 4)
            {

            $office=DB::table('hrms_offices')->where('hrms_officecode',$row[6])->first();
       
             $distcode=$office->distcode;
             $deptcode=$office->deptcode;
             $officecode=$office->officecode;
             $deptslno=$this->createDeptslnoCode($distcode,$deptcode,$officecode);
             if($distcode!=-1 and $distcode!=null and $deptcode!=null and $officecode!=null and $officecode!=null and $deptslno!=null)
                {
                    $this->count=$this->count+1;
                // DB::table($this->tableName)->insert([
                //     'hrms_distcode' => $row[0],
                //     'distcode' => $distcode ,
                //     'hrms_deptcode' => $row[1],
                //     'deptcode' =>$deptcode ,
                //     'hrms_officecode' => $row[2],
                //     'officecode' => $officecode,
                //     'officename'=>$row[3],
                //     'officeaddress'=>$row[4],
                //     'created_at'=>now(),
                //     'updated_at'=>now()
                //                 // ... Map columns from your Excel file to the table
                // ]);
                $basicpay = null;
                $category =  null;
                if($row[11]!="NULL")
                {
                    $basicpay = intval($row[11]);
                }
                if($row[9]!="NULL")
                {
                    if($row[9]==1)
                    {
                        $category = "A";
                    }
                    elseif($row[9]==2)
                    {
                        $category = "B";
                    }
                    else
                    {
                        $category = "C";

                    }
                }
                $dob =  Carbon::createFromDate(1900, 1, 1)->addDays($row[3] - 2);
                $dor =  Carbon::createFromDate(1900, 1, 1)->addDays($row[4] - 2);
                
                DB::table('polling_data')->insert([
                    'distcode' => $distcode,
                    'deptcode' => $deptcode ,
                    'officecode' => $officecode,
                    'photoid' => $this->generatePhotoId($distcode,$deptcode,$officecode,$deptslno),
                    'Name' => $row[1],
                    'FName' => $row[2],
                    'hrmscode'=>$row[0],
                    'EmpTypeId'=>1,
                    'mobileno'=>$row[15],
                    'sex'=>substr($row[8],0,1),
                    'dob'=>Carbon::parse($row[3]),
                    'deptslno'=>$deptslno,
                    'category'=>$category,
                    'emailid'=>$row[16],
                    'basicPay'=>$basicpay,
                    'dob'=>$dob,
                    'retiredt'=>$dor,
                    'PayScaleCode'=>($row[10]=='NULL' or $row[10]=='')?null:($this->getPayScaleCode($distcode,$row[10])),
                    'BankId'=>$this->getBankId($row[17]),
                    'IfscCode'=>$row[18],
                    'BankAcNo'=>$row[19],
                    'del'=>'o',
                    'hrmsdata'=>1,
                    'DesigCode'=>$this->getDesignationCode($row[7]),
                    'created_at'=>now(),
                    'updated_at'=>now()
                                // ... Map columns from your Excel file to the table
                ]);
            }
            
        }});

        foreach($this->distcodelist as $dist)
            {
                foreach(DeptMaster::where('distcode',$dist->distcode)->get() as $dept)
                {
                    OfficeMaster::where('distcode',$dist->distcode)->where('hrmsdata',1)->where('deptcode',$dept->deptcode)->whereNotIn('officecode',Polling_data::where('distcode',$dist->distcode)->where('hrmsdata',1)->where('deptcode',$dept->deptcode)->get('officecode'))->delete();
                }
            }

        // Optionally, you can delete the uploaded file after import
        // unlink(storage_path("app/$path"));



        $endtime=microtime(true);
        $this->exectime=$endtime-$strttime;
        session()->flash('success', 'Data imported and table created successfully.');
     
        // Clear the input fields
        $this->reset(['file', 'tableName']);
    }
}
