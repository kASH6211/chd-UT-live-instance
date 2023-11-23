<?php

namespace App\Http\Livewire\Import\Hrms;

use Livewire\Component;
use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelReader;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use App\Imports\ExcelImports\DistrictImport;
use App\Models\DistMaster;
use App\Models\DeptMaster;
use App\Models\SubDeptMaster;
use App\Models\OfficeMaster;
use Illuminate\Support\Facades\Auth;
use App\Models\Bank;
use App\Models\PayScale;
use App\Models\PollingData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\HrmsDistrict;
use App\Models\HrmsOffice;
use App\Models\HrmsDepartment;
use App\Models\HrmsDesignation;
use App\Models\PollingDataPhoto;
use Session;

use App\Models\DesignationMaster;
use Illuminate\Support\Facades\DB;

class MasterData extends Component
{
    use WithFileUploads;
    protected $polling_data_ram;
    public $file;
    public $tableName ="hrms_districts";
    public $notmappedlist =[];
    public $notmappedcount =0;
    public $distcodelist = [];
    public $completedRecords = 0;
    public $totalRecords = 0;
    public $header;
    public $count;
    protected $i=0;
    public function render()
    {
        return view('livewire.import.hrms.master-data');
    }
    public function updateProgress()
    {
        $this->emit('progressUpdated', $this->totalRecords, $this->completedRecords);
    }
    
    public function getDiseDistCode($districtname)
    {
        $dist = DistMaster::where('DistName', 'ILIKE', '%' . $districtname. '%')->first();
        if($dist)
        {
            return $dist->DistCode;
        }
        return -1;

    }
    public function getDiseDistFromHrms($hrms_distcode)
    {
       
            $distcode = DB::table('hrms_districts')->where('hrms_distcode',$hrms_distcode)->first();
          
    
            if($distcode)
              return $distcode->dise_distcode;
            else
            return null;
        

    }
    public function getDiseDeptFromHrms($hrms_deptcode)
    {
       
            $deptcode = DB::table('hrms_departments')->where('hrms_deptcode',$hrms_deptcode)->first();
                    if($deptcode)
              return $deptcode->dise_deptcode;
            else
            return null;
        

    }
    public function getUnmappedData()
    {
      $this->notmappedlist = DB::table($this->tableName)->where('dise_distcode',-1)->get();
      $this->notmappedcount = $this->notmappedlist->count();
      
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
    public function createDeptCode($distcode)
    {
       $offset = 5000;
       $code =-1;
        $dept = DeptMaster::where('distcode',$distcode)->where('hrmsdata',1)->orderBy('deptcode','DESC')->first();
        //dd($dept);
        if($dept)
        {
            $code = intval($dept->deptcode)+1;
        }
        else
        {   
            
            $code = $offset +1;
        }
        return $code;
    }
    
    public function getDiseDeptCode($distcode, $deptname, $address)
    {
       
            $deptcode = $this->createDeptCode($distcode);
           
            $deptcodekey = $distcode.$deptcode;
            DeptMaster::create(
                [
                    'distcode'=>$distcode,
                    'deptcode'=> $deptcode,
                    'address'=>$address,
                    'catcode'=>1,
                    'deptname'=>$deptname,
                    'CentreState'=>0,
                    'deptcodekey'=>$deptcodekey,
                    'hrmsdata'=>1
                ]
            );
            SubDeptMaster::create([
                'distcode'=>$distcode,
                'deptcode'=> $deptcode,
                'subdeptcode'=>'0001',
                'subdept'=>$deptname,
                'address'=>$address,
                'subdeptcodekey'=>$deptcodekey.'0001',
                'distcode_from'=>0,
                'hrmsdata'=>1
            ]);

       return $deptcode;
        

    }
    public function createOfficeCode($distcode,$deptcode)
    {
       $offset = 5000;
       $code =-1;
        $office = OfficeMaster::where('distcode',$distcode)->where('deptcode',$deptcode)->where('hrmsdata',1)->orderBy('id','DESC')->withTrashed()->first();
        if($office)
        {
            $code = intval($office->officecode)+1;
        }
        else
        {   
            
            $code = $offset +1;
        }
        return $code;
    }
    public function createDesigCode($distcode)
    {
       $offset = 5000;
       $code =-1;
        $desig = DesignationMaster::where('distcode',$distcode)->where('hrmsdata',1)->orderBy('id','DESC')->first();
        if($desig)
        {
            
            $code = intval($desig->DesigCode)+1;
        }
        else
        {   
            
            $code = $offset +1;
        }
        return $code;
    }
    public function getDiseDesigCode($distcode, $designation,$class,$selectedcp)
    {
       
        $desigcode = $this->createDesigCode($distcode);
           
            $desigcodekey = $distcode.$desigcode;
            DesignationMaster::create(
                [
                    'distcode'=>$distcode,
                    'DesigCode'=> $desigcode,
                    'Designation'=>$designation,
                    // 'SelectedCP'=>1,
                     'class'=>$class,
                     'hrmsdata' => 1,
                     'SelectedCP'=>$selectedcp,
                    'distcode_from'=>0,
                    'desigcodekey'=>$desigcodekey,
                    
                ]
            );
           

       return $desigcode;
        

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
        $t1=now();
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
    public function  checkEmailExistInUser($email)
    {
        $em = DB::table('users')->where('email',$email)->first();
        if($em)
          return true;
        else
        return false;
    }
    public function  checkMobileExistInUser($mobile)
    {
        $mb = DB::table('users')->where('mobileno',$mobile)->first();
        if($mb)
          return true;
        else
        return false;
    }
    public function getStateCode()
    {
        $stcode = DistMaster::first()['st_Code'];
      
        return $stcode;
    }
    public function generateUserId($distcode, $deptcode,$officecode)
    {
        $finaluserid = "";
        $count = User::where('distcode',$distcode)->where('deptcode',$deptcode)->where('officecode',$officecode)->count();
            $count= $count+1;
            if($count<10)
                $count =  '0'.$count;
            
            if($distcode<10)
                $distcode = '0'.$distcode;

            $finaluserid = $distcode.$deptcode.$officecode.$count;
        return $finaluserid;

 }

 protected $rules=[
        'file' => 'required|file|max:100480|mimes:csv', // 16MB in kilobytes
    ];
    public function importCsv($path,$table)
    {
        // Path to the CSV file
        $csvFilePath = $path;
    
        // Your table name
        $tableName = $table;
        if(Schema::hasTable($this->tableName))
        {
            DB::table($tableName)->truncate();
        }
        // Raw SQL query for bulk insertion
        $sql = <<<SQL
        COPY $tableName FROM '$csvFilePath' DELIMITER ',' CSV HEADER ENCODING 'win1252';
        SQL;
    
       
            DB::unprepared($sql);
            //dd("success");// return redirect()->back()->with('success', 'CSV data imported successfully');
       
    }

    public function import()
    {
        set_time_limit(10000);
        ini_set('memory_limit', '1024M');
        
        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);
        
        // Store the uploaded Excel file
        $path = $this->file->store('temp');
       
        // Import data from the Excel file using your custom import class
        $excelfile = Excel::toCollection(new DistrictImport, $path);
        
        $districts =$excelfile[0];  // Slice(1) removes first row from the collection (first row is the header row).
        $departments = $excelfile[1];
        $offices = $excelfile[2];
        $designations = $excelfile[3];
        //$employees = $excelfile[4]->slice(1);
      
        //  $this->totalRecords = $this->totalRecords + count($districts) + count($departments) + count($offices) + count($designations) + count($employees);
        
         $this->addDistrict($districts);
         $this->addDepartments($departments);
         $this->addOffices($offices);
        $this->addDesignations($designations);
         //$this->addEmployees($employees);

        // Optionally, you can delete the uploaded file after import
       unlink(storage_path("app/$path"));

    }

    public function softDeleteHrmsExtraRecords($data)
    {
        //dd($data['compareTable']->pluck($data['compareTableIndex']));
        $records= DB::table($data['mainTable'])->whereNotIn($data['mainTableIndex'], $data['compareTable']->pluck($data['compareTableIndex']))->get();
        
       // dd($records);
        $modelname = $data['tablemodel'];
        $model = "App\Models"."\\".$modelname;
        $modelInstance = app($model);
        foreach($records as $record)
        {
            $row = $modelInstance::find($record->id); 
            if($row)
            {
                $row->delete();
            }
        }
    }

    public function softDeleteDiseExtraRecords($data)
    {
        //dd($data['compareTable']->pluck($data['compareTableIndex']));
        $records= DB::table($data['mainTable'])->whereNotIn($data['mainTableIndex'], DB::table($data['compareTable'])->whereNull('deleted_at')->pluck($data['compareTableIndex']))->get();
        // DB::table
       //dd($records);
        $modelname = $data['tablemodel'];
        $model = "App\Models"."\\".$modelname;
        $modelInstance = app($model);
        foreach($records as $record)
        {
            $row = $modelInstance::find($record->id); 
            if($row)
            {
                $row->delete();
            }
        }
    }

    // public function softDeleteDiseExtraRecords($mainTable,$compareTable,$mainTableIndex,$compareTableIndex,$distcode)
    // {
    //     $records= DB::table($mainTable)->whereNotIn($mainTableIndex, DB::table($compareTable)->pluck($compareTableIndex))->get();
        
    //     foreach($records as $record)
    //     {
    //         DistMaster::find($record->id)->delete(); 
    //     }
    // }

    public function recordExistAndUpdate($data )
    {
        $result = null;
        $searchindex = array_search( $data['columntocomparewith'],$data['excelheader']->toArray());
           // dd($searchindex);
        $modelname = $data['tablemodel'];
        $model = "App\Models"."\\".$modelname;
        $modelInstance = app($model);
        $record = $modelInstance::where($data['columntocomparewith'],$data['excelrow'][$searchindex])->first();
        //dd($record);
        if($record)
        {
           foreach($data['excelheader'] as $index =>$head)
           {
                 $head=trim($head);
                $record->$head = $data['excelrow'][$index];
           } 
          $record->save();
          $ctr = $data['columntoreturn'];
            $result = $record->$ctr;
        }
        return $result;  
    }


    // public function addDistrict($dist)
    // {
    //     $this->tableName ="hrms_districts";
    //   //  $this->header = $dist[0];
    //     $districts = $dist->slice(1);
    //   //  $this->softDeleteExtraRecords('dist_masters',$this->tableName,'DistCode', 'dise_distcode');
       
    //   // Create a new table in the database if it does not exist
    //    if(!Schema::hasTable($this->tableName))
    //         Schema::create($this->tableName, function ($table) {
    //             $table->id();
    //             $table->string('hrms_distcode');
    //             $table->string('hrms_district');
    //             $table->integer('dise_distcode');
    //             $table->timestamps();
    //         });
      
        
    //     $districts->each(function ($row) {
          
    //         $data = [
               
    //             "tablename" =>$this->tableName,
    //             "excelrow" =>$row,
    //             "excelheader"=>$this->header,
    //             "columntocomparewith" =>'hrms_distcode',
    //             "columntoreturn" =>'dise_distcode',
    //         ];
           
    //      $disecd =  $this->recordExistAndUpdate($data);  // Check if current record already exist in database

    //      if(!$disecd)  // If $discd is not null means record is present and it has been updated.
    //      {
    //         // Record not present in databas hence we will add new record
    //      }
    //         DB::table($this->tableName)->insert([
    //             'hrms_distcode' => $row[0],
    //             'hrms_district' => $row[1],
    //             'dise_distcode' => $this->getDiseDistCode($row[1]),
    //             'created_at'=>now(),
    //             'updated_at'=>now()
    //                             // ... Map columns from your Excel file to the table
    //         ]);
    //         $this->completedRecords = $this->completedRecords +1;
            
    //     });
    //     session()->flash('success', 'Data imported and table created successfully.');
    //     $this->getUnmappedData();
    //     // Clear the input fields
    //     $this->reset(['tableName']);

    // }
    

    public function addDistrict($dist)
    {
        $districts = $dist->slice(1);
       $this->tableName ="hrms_districts";
       // Create a new table in the database if it does not exist
       if(Schema::hasTable($this->tableName))
        {
            Schema::dropIfExists($this->tableName);
        }
        Schema::create($this->tableName, function ($table) {
            $table->id();
            $table->string('hrms_distcode');
            $table->string('hrms_district');
            $table->integer('dise_distcode');
            // ... Define table columns based on your data
            $table->timestamps();
        });
         
        // Insert data into the newly created table
        $districts->each(function ($row) {
            
            DB::table($this->tableName)->insert([
                'hrms_distcode' => $row[0],
                'hrms_district' => $row[1],
                'dise_distcode' => $this->getDiseDistCode($row[1]),
                'created_at'=>now(),
                'updated_at'=>now()
                                // ... Map columns from your Excel file to the table
            ]);
           
            
        });
        session()->flash('success', 'Data imported and table created successfully.');
        $this->getUnmappedData();
        // Clear the input fields
        $this->reset(['tableName']);

    }
    public function addDepartments($depts)
    {
        
        $this->tableName ="hrms_departments";
        $this->header = $depts[0];
        $departments = $depts->slice(1);
        $this->distcodelist = DistMaster::get('DistCode');
       // Schema::dropIfExists($this->tableName);
        if(!Schema::hasTable($this->tableName))
        {
            Schema::create($this->tableName, function ($table)
            {
                $table->id();
                $table->string('hrms_deptcode');
                $table->string('hrms_department');
                $table->string('hrms_department_address');
                $table->integer('dise_deptcode');
                $table->softDeletes();
                // ... Define table columns based on your data
                $table->timestamps();
            });
        }
      
        $departments->each(function ($row) {

            $this->i=$this->i+1;
            
            $data = [
                "tablename" =>$this->tableName,
                "excelrow" =>$row,
                "excelheader"=>$this->header,
                "columntocomparewith" =>'hrms_deptcode',
                "columntoreturn" =>'dise_deptcode',
                "tablemodel"=>"HrmsDepartment"
            ];
            $disecd =  $this->recordExistAndUpdate($data);
            /**************
                 * if disecd is not null  --> this means current record in excel row was found in hrms_departments table and hrms_departments table's found row is updated with new data and mapping code with dept_masters is returned.
                 * if disecd is not null ---> As hrms_departments table is updated using $this->recordExistAndUpdate($data) function now only thing left is to update dept_masters table
                 * if disecd is null     ---> This means that this is a new record and thus needs to perform two entries of this row one in hrms_departments and other in dept_masters.
                 */
            if($disecd)
            {
                
                foreach($this->distcodelist as $dist)
                {
                    $dept = DeptMaster::where('deptcode',$disecd)->where('distcode',$dist->DistCode)->first();
                    if($dept)
                    {
                        $dept->deptname = $row[1];
                        $dept->address =  $row[2];
                        $dept->save();
                    }
                    else
                    {
                        $deptcodekey = $dist->DistCode.$disecd;
                        DeptMaster::create(
                            [
                                'distcode'=>$dist->DistCode,
                                'deptcode'=> $disecd,
                                'address'=>$row[2],
                                'catcode'=>1,
                                'deptname'=>$row[1],
                                'CentreState'=>0,
                                'deptcodekey'=>$deptcodekey,
                                'hrmsdata'=>1
                            ]
                        );
                        SubDeptMaster::create([
                            'distcode'=>$dist->DistCode,
                            'deptcode'=> $disecd,
                            'subdeptcode'=>'0001',
                            'subdept'=>$row[1],
                            'address'=>$row[2],
                            'subdeptcodekey'=>$deptcodekey.'0001',
                            'distcode_from'=>0,
                            'hrmsdata'=>1
                        ]);
            

                    }
                }
            }        
            else
            {
                    //New Entry

                foreach($this->distcodelist as $dist)
                {
                    $disedeptcode=$this->getDiseDeptCode($dist->DistCode,$row[1],$row[2]);
                }
                DB::table($this->tableName)->insert([

                    'hrms_deptcode' => $row[0],
                    'hrms_department' => $row[1],
                    'hrms_department_address' => $row[2],
                    'dise_deptcode' => $disedeptcode,
                    'created_at'=>now(),
                    'updated_at'=>now()
                                            // ... Map columns from your Excel file to the table
                 ]);


                        
            }
            
                
            Session::put('completed',now());
            
        });
        // Session::put('completed',0);
        
       $data=[
        'mainTable'=>$this->tableName,
        'mainTableIndex'=>'hrms_deptcode',
        'compareTable'=>$departments,
        'compareTableIndex'=>'0',
        'tablemodel'=>'HrmsDepartment',
       ];
        $this->softDeleteHrmsExtraRecords($data);

        $data1=[
            'mainTable'=>'dept_masters',
            'mainTableIndex'=>'deptcode',
            'compareTable'=>$this->tableName,
            'compareTableIndex'=>'dise_deptcode',
            'tablemodel'=>'DeptMaster',
           ];
      $this->softDeleteDiseExtraRecords($data1); 
        session()->flash('success', 'Data imported and table created successfully.');
     
        // Clear the input fields
        $this->reset(['tableName']);

    } 
 
    // public function addDepartments($departments)
    // {
    //    $this->tableName ="hrms_departments";
    //    $this->distcodelist = DistMaster::get('id');
      
    //     if(Schema::hasTable($this->tableName))
    //     {
    //         Schema::dropIfExists($this->tableName);
    //     }
    //     Schema::create($this->tableName, function ($table) {
    //         $table->id();
    //         $table->string('hrms_deptcode');
    //         $table->string('hrms_department');
    //         $table->string('hrms_department_address');
    //         $table->integer('dise_deptcode');
    //         // ... Define table columns based on your data
    //         $table->timestamps();
    //     });
    //     DB::table('subdept_masters')->where('hrmsdata',1)->delete();
    //    // $pd =  DB::table('polling_data')->where('hrmsdata',1)->pluck('photoid')->toArray();
    //   //  DB::table('polling_data_photos')->whereIn('id',$pd)->delete();
      
    //     DB::table('polling_data')->where('hrmsdata',1)->delete();
     
    //     DB::table('users')->where('officecode','>',5000)->delete();
        
    //     DB::table('office_masters')->where('hrmsdata',1)->delete();
        
    //     DB::table('dept_masters')->where('hrmsdata',1)->delete();

    //     $firstRow = true;
    //     $this->count = 0;
    //     $departments->each(function ($row) use (&$firstRow) {
    //         if ($firstRow) {
    //             // Skip the first row
    //             $firstRow = false;
    //             return;
    //         }
    //         $this->count=$this->count+1;
    //         foreach($this->distcodelist as $dist)
    //         {
    //             DB::table($this->tableName)->insert([

    //                 'hrms_deptcode' => $row[0],
    //                 'hrms_department' => $row[1],
    //                 'hrms_department_address' => $row[2],

    //                 'dise_deptcode' => $this->getDiseDeptCode($dist->id,$row[1],$row[2]),
    //                 'created_at'=>now(),
    //                 'updated_at'=>now()
    //                             // ... Map columns from your Excel file to the table
    //             ]);
    //         }
    //         $this->completedRecords = $this->completedRecords +1;
            

    //     });
    //     session()->flash('success', 'Data imported and table created successfully.');
     
    //     // Clear the input fields
    //     $this->reset(['tableName']);

    // } 

    // public function addOffices($offices)
    // {
    //     $this->tableName ="hrms_offices";

    //     if(Schema::hasTable($this->tableName))
    //     {
    //         Schema::dropIfExists($this->tableName);
    //     }
    //     Schema::create($this->tableName, function ($table) {
    //         $table->id();
    //         $table->string('hrms_distcode');
    //         $table->integer('distcode')->nullable();
    //         $table->string('hrms_deptcode');
    //         $table->string('deptcode')->nullable();
    //         $table->string('hrms_officecode');
    //         $table->string('officecode')->nullable();
    //         $table->string('officename');
    //         $table->string('officeaddress');
    //         $table->timestamps();
    //     });
    //     DB::table('office_masters')->where('officecode','>','5000')->delete();
    //     $firstRow = true;
    //     $this->count = 0;
    //     $offices->each(function ($row) use (&$firstRow) {
    //         if ($firstRow) {
    //             // Skip the first row
    //             $firstRow = false;
    //             return;
    //         }
    //         $this->count=$this->count+1;
    //         $distcode=$this->getDiseDistFromHrms($row[0]);
    //         $deptcode=$this->getDiseDeptFromHrms($row[1]);
    //         $officecode=$this->createOfficeCode($distcode,$deptcode);
    //         if($distcode!=-1 and $distcode!=null and $deptcode!=null and $officecode!=null)
    //            {
    //                $this->count=$this->count+1;
    //            DB::table($this->tableName)->insert([
    //                'hrms_distcode' => $row[0],
    //                'distcode' => $distcode ,
    //                'hrms_deptcode' => $row[1],
    //                'deptcode' =>$deptcode ,
    //                'hrms_officecode' => $row[2],
    //                'officecode' => $officecode,
    //                'officename'=>$row[3],
    //                'officeaddress'=>$row[4],
    //                'created_at'=>now(),
    //                'updated_at'=>now()
    //                            // ... Map columns from your Excel file to the table
    //            ]);

               
    //            DB::table('office_masters')->insert([
    //                'distcode' => $distcode,
    //                'deptcode' => $deptcode ,
    //                'officecode' => $officecode,
    //                'office' => substr($row[3], 0, 50),
    //                'address' => substr($row[4], 0, 50),
    //                'officecodekey' => ($distcode<10?"0":"").$distcode.$deptcode.$officecode,
    //                'EmailID'=>substr($row[5], 0, 50),
    //                'subdeptcode'=>'0001',
    //                'hrmsdata'=>1,
    //                'created_at'=>now(),
    //                'updated_at'=>now()
    //                            // ... Map columns from your Excel file to the table
    //            ]);

    //            // Creating office User
    //            $emailaddress = substr($row[5], 0, 50);

    //          if(preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $emailaddress) and preg_match('/^\d{10}$/', $row[6]))
    //          {
    //               //  $email_exist = $this->checkEmailExistInUser($emailaddress);
    //               $email_exist = false;  
    //               $mobile_exist = $this->checkMobileExistInUser($row[6]);
    //                 $password= Hash::make('12345678');
    //                 if(!$email_exist and  !$mobile_exist)
    //                 {
    //                     DB::table('users')->insert([
    //                         'st_Code'=>$this->getStateCode(),
    //                         'distcode' => $distcode,
    //                         'deptcode' => $deptcode ,
    //                         'officecode' => $officecode,
    //                         'name' => substr($row[3], 0, 50),
    //                         'email'=>$emailaddress,
    //                         'password'=>$password,
    //                         'role_id'=>4,
    //                         'user_id'=>$this->generateUserId($distcode,$deptcode,$officecode),
    //                         'mobileno'=>$row[6],
    //                         'created_at'=>now(),
    //                         'updated_at'=>now()
    //                                     // ... Map columns from your Excel file to the table
    //                     ]);
    //                 }

    //            }
    //        }
    //        $this->completedRecords = $this->completedRecords +1;
           

    //    });


    //    foreach($this->distcodelist as $dist)
    //        {
    //            DeptMaster::where('distcode',$dist->distcode)->where('hrmsdata',1)->whereNotIn('deptcode',OfficeMaster::where('distcode',$dist->distcode)->where('hrmsdata',1)->get('deptcode'))->delete();
    //        }
      

    //    session()->flash('success', 'Data imported and table created successfully.');
    
    //    // Clear the input fields
    //    $this->reset(['tableName']);
    // }

    public function softDeleteHrmsExtraRecordsOffice($data)
    {
        //dd($data['compareTable']->pluck($data['compareTableIndex']));
        //$records= DB::table($data['mainTable'])->whereNotIn($data['mainTableIndex'], $data['compareTable']->pluck($data['compareTableIndex']))->get();
        $missingOffices = HrmsOffice::whereNotIn(['distcode', 'deptcode', 'officecode'], HrmsOffice::get(['distcode','deptcode','officecode'])->toArray())
    ->get();
        dd($missingOffices);
        $modelname = $data['tablemodel'];
        $model = "App\Models"."\\".$modelname;
        $modelInstance = app($model);
        foreach($records as $record)
        {
            $row = $modelInstance::find($record->id); 
            if($row)
            {
                $row->delete();
            }
        }
    }

    public function softDeleteDiseExtraRecordsOffice($data)
    {
        //dd($data['compareTable']->pluck($data['compareTableIndex']));
        $records= DB::table($data['mainTable'])->whereNotIn($data['mainTableIndex'], DB::table($data['compareTable'])->whereNull('deleted_at')->pluck($data['compareTableIndex']))->get();
        // DB::table
       //dd($records);
        $modelname = $data['tablemodel'];
        $model = "App\Models"."\\".$modelname;
        $modelInstance = app($model);
        foreach($records as $record)
        {
            $row = $modelInstance::find($record->id); 
            if($row)
            {
                $row->delete();
            }
        }
    }

    
    public function recordExistAndUpdateOffice($data )
    {
        $result = null;
        $searchindex0 = array_search( $data['columntocomparewith'][0],$data['excelheader']->toArray());
        $searchindex1 = array_search( $data['columntocomparewith'][1],$data['excelheader']->toArray());
        $searchindex2 = array_search( $data['columntocomparewith'][2],$data['excelheader']->toArray());
        //dd($searchindex2);
        $modelname = $data['tablemodel'];
        $model = "App\Models"."\\".$modelname;
        $modelInstance = app($model);
        $record = $modelInstance::where($data['columntocomparewith'][0],$data['excelrow'][$searchindex0])->where($data['columntocomparewith'][1],$data['excelrow'][$searchindex1])->where($data['columntocomparewith'][2],$data['excelrow'][$searchindex2])->withTrashed()->first();
        
        if($record)
        {
            $record->restore();

           foreach($data['excelheader'] as $index =>$head)
           {
                 $head=trim($head);
                $record->$head = $data['excelrow'][$index];
           } 
           
           
           $offc=OfficeMaster::withTrashed()->where('distcode',$record->distcode)->where('deptcode',$record->deptcode)->where('officecode',$record->officecode)->first();
           $offc->restore();
           $offc->office=substr($record->officename, 0, 50);
           $offc->address=substr($record->officeaddress, 0, 50);
           
           if($data['newdistcode']!=$record->distcode or $data['newdeptcode']!=$record->deptcode )
           {
            $record->distcode=$data['newdistcode'];
            $record->deptcode=$data['newdeptcode'];
            $record->officecode=$this->createOfficeCode($record->distcode,$record->deptcode);
            $offc->distcode=$record->distcode;
            $offc->deptcode=$record->deptcode;
            $offc->officecode=$record->officecode;
            $offc->officecodekey = ($offc->distcode<10?"0":"").($offc->distcode).($offc->deptcode).($offc->officecode);
           }

           $offc->save();
          $record->save();
          
          $ctr0 = $data['columntoreturn'][0];
          
            $result = [$record->$ctr0];
        }
        return $result;  
    }
    public function addOffices($offc)
    {
        $this->tableName ="hrms_offices";
       
        $this->header = $offc[0];
       // $this->softDeleteExtraRecords('dist_masters',$this->tableName,'DistCode', 'dise_distcode');
        $offices = $offc->slice(1);
     
       // Schema::dropIfExists($this->tableName);
    //    if(Schema::hasTable($this->tableName))
    //     {
    //         Schema::dropIfExists($this->tableName);
    //     }
        if(!Schema::hasTable($this->tableName))
        {
            Schema::create($this->tableName, function ($table)
            {
                $table->id();
                $table->string('hrms_distcode');
                $table->integer('distcode')->nullable();
                $table->string('hrms_deptcode');
                $table->string('deptcode')->nullable();
                $table->string('hrms_officecode');
                $table->string('officecode')->nullable();
                $table->string('officename');
                $table->string('officeaddress');
                $table->softDeletes();
                // ... Define table columns based on your data
                $table->timestamps();
            });
        }


        $hrms=HrmsOffice::get();
       foreach($hrms  as $h)
       {
        $h->delete();
       }
       $offcmast=OfficeMaster::where('hrmsdata',1);
       if($offcmast)
       {$offcmast->delete();}


        $offices->each(function ($row) {
            $distcode=$this->getDiseDistFromHrms($row[0]);
            $deptcode=$this->getDiseDeptFromHrms($row[1]);
          

            if($distcode!=-1 and $distcode!=null and $deptcode!=null)
            {
                $data = [
                    "tablename" =>$this->tableName,
                    "excelrow" =>$row,
                    "excelheader"=>$this->header,
                    "columntocomparewith" =>['hrms_distcode','hrms_deptcode','hrms_officecode'],
                    "columntoreturn" =>['distcode','deptcode','officecode'],
                    "newdistcode"=>$distcode,
                    "newdeptcode"=>$deptcode,
                    "tablemodel"=>"HrmsOffice"
                ];
                $disecd =  $this->recordExistAndUpdateOffice($data);

               if($disecd )  
               {

               }
               else
               {  
                $officecode=$this->createOfficeCode($distcode,$deptcode);
               DB::table($this->tableName)->insert([
                   'hrms_distcode' => $row[0],
                   'distcode' => $distcode ,
                   'hrms_deptcode' => $row[1],
                   'deptcode' =>$deptcode ,
                   'hrms_officecode' => $row[2],
                   'officecode' => $officecode,
                   'officename'=>$row[3],
                   'officeaddress'=>$row[4],
                   'created_at'=>now(),
                   'updated_at'=>now()
                               // ... Map columns from your Excel file to the table
               ]);
            

               
               DB::table('office_masters')->insert([
                   'distcode' => $distcode,
                   'deptcode' => $deptcode ,
                   'officecode' => $officecode,
                   'office' => substr($row[3], 0, 50),
                   'address' => substr($row[4], 0, 50),
                   'officecodekey' => ($distcode<10?"0":"").$distcode.$deptcode.$officecode,
                //    'EmailID'=>substr($row[5], 0, 50),
                   'subdeptcode'=>'0001',
                   'hrmsdata'=>1,
                   'created_at'=>now(),
                   'updated_at'=>now()
                               // ... Map columns from your Excel file to the table
               ]);
            }
            //    // Creating office User
            //    $emailaddress = substr($row[5], 0, 50);

            //  if(preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $emailaddress) and preg_match('/^\d{10}$/', $row[6]))
            //  {
            //       //  $email_exist = $this->checkEmailExistInUser($emailaddress);
            //       $email_exist = false;  
            //       $mobile_exist = $this->checkMobileExistInUser($row[6]);
            //         $password= Hash::make('12345678');
            //         if(!$email_exist and  !$mobile_exist)
            //         {
            //             DB::table('users')->insert([
            //                 'st_Code'=>$this->getStateCode(),
            //                 'distcode' => $distcode,
            //                 'deptcode' => $deptcode ,
            //                 'officecode' => $officecode,
            //                 'name' => substr($row[3], 0, 50),
            //                 'email'=>$emailaddress,
            //                 'password'=>$password,
            //                 'role_id'=>4,
            //                 'user_id'=>$this->generateUserId($distcode,$deptcode,$officecode),
            //                 'mobileno'=>$row[6],
            //                 'created_at'=>now(),
            //                 'updated_at'=>now()
            //                             // ... Map columns from your Excel file to the table
            //             ]);
            //         }

            //    }
           }
           $this->completedRecords = $this->completedRecords +1;
           

       });

      
    //    foreach($this->distcodelist as $dist)
    //        {
    //            DeptMaster::where('distcode',$dist->distcode)->where('hrmsdata',1)->whereNotIn('deptcode',OfficeMaster::where('distcode',$dist->distcode)->where('hrmsdata',1)->get('deptcode'))->delete();
    //        }
      

       session()->flash('success', 'Data imported and table created successfully.');
    
       // Clear the input fields
       $this->reset(['tableName']);
    }
    public function addDesignations($desigs)
    {
        $this->tableName ="hrms_designations";
        
        $this->header = $desigs[0];
        $designations = $desigs->slice(1);
        $this->distcodelist = DistMaster::get('DistCode');
       // Schema::dropIfExists($this->tableName);
        if(!Schema::hasTable($this->tableName))
        {
            Schema::create($this->tableName, function ($table)
            {
                $table->id();
                $table->string('hrms_desigcode');
                $table->string('hrms_designation');
                $table->string('dise_desigcode');
                $table->string('hrms_class');
                $table->string('hrms_selectedcp');
                $table->softDeletes();
                // ... Define table columns based on your data
                $table->timestamps();
            });
        }
        // Insert data into the newly created table
        $designations->each(function ($row) {
            
            $data = [
                "tablename" =>$this->tableName,
                "excelrow" =>$row,
                "excelheader"=>$this->header,
                "columntocomparewith" =>'hrms_desigcode',
                "columntoreturn" =>'dise_desigcode',
                "tablemodel"=>"HrmsDesignation"
            ];
            $disecd =  $this->recordExistAndUpdate($data);
            if($disecd)
            {
                foreach($this->distcodelist as $dist)
                {
                    $desig = DesignationMaster::where('DesigCode',$disecd)->where('distcode',$dist->DistCode)->first();
                    if($desig)
                    {
                        $desig->Designation = $row[1];
                        $desig->class = $row[2];
                        $desig->SelectedCP = $row[3];
                        $desig->save();
                    }
                    else
                    {
                        DB::table($this->tableName)->insert([

                            'hrms_desigcode' => $row[0],
                            'hrms_designation' => $row[1],
                            'dise_desigcode' => $this->getDiseDesigCode($dist->DistCode,$row[1],$row[2],$row[3]),
                            'created_at'=>now(),
                            'updated_at'=>now()
                                                // ... Map columns from your Excel file to the table
                        ]);
                    }
                }
            }        
            else
            {
                    //New Entry

                foreach($this->distcodelist as $dist)
                {
                    $disedeptcode=$this->getDiseDesigCode($dist->DistCode,$row[1],$row[2],$row[3]);
                }
                DB::table($this->tableName)->insert([

                    'hrms_desigcode' => $row[0],
                    'hrms_designation' => $row[1],
                    'dise_desigcode' => $disedeptcode,
                    'hrms_class' => $row[2],
                    'hrms_selectedcp' => $row[3],
                    'created_at'=>now(),
                    'updated_at'=>now()
                                        // ... Map columns from your Excel file to the table
                ]);
                        
            }
        });



        $data=[
            'mainTable'=>$this->tableName,
            'mainTableIndex'=>'hrms_desigcode',
            'compareTable'=>$designations,
            'compareTableIndex'=>'0',
            'tablemodel'=>'HrmsDesignation',
           ];
            $this->softDeleteHrmsExtraRecords($data);
    
            $data1=[
                'mainTable'=>'designation_masters',
                'mainTableIndex'=>'DesigCode',
                'compareTable'=>$this->tableName,
                'compareTableIndex'=>'dise_desigcode',
                'tablemodel'=>'DesignationMaster',
               ];
          $this->softDeleteDiseExtraRecords($data1); 
        session()->flash('success', 'Data imported and table created successfully.');
     
        // Clear the input fields
        $this->reset(['tableName']);

    }
    // public function addDesignations($designations)
    // {
    //     $this->tableName ="hrms_designations";
        
    //     $strttime=microtime(true);
    //     if(Schema::hasTable($this->tableName))
    //     {
    //         Schema::dropIfExists($this->tableName);
    //     }
        

    //     Schema::create($this->tableName, function ($table) {
    //         $table->id();
    //         $table->string('hrms_desigcode');
    //         $table->string('hrms_designation');
           
    //         $table->string('dise_desigcode');
    //         // ... Define table columns based on your data
    //         $table->timestamps();
    //     });
    //     // Create a new table in the database if it does not exist
    //     DB::table('designation_masters')->where('hrmsdata',1)->delete();
    //     $firstRow = true;
    //     $this->count = 0;
        
    //     // Insert data into the newly created table
    //     $designations->each(function ($row)use (&$firstRow) {
    //         if ($firstRow) {
    //             // Skip the first row
    //             $firstRow = false;
    //             return;
    //         }
            

    //         $this->count=$this->count+1;
    //         foreach($this->distcodelist as $dist)
    //         {
    //             DB::table($this->tableName)->insert([

    //                 'hrms_desigcode' => $row[0],
    //                 'hrms_designation' => $row[1],
                    

    //                 'dise_desigcode' => $this->getDiseDesigCode($dist->id,$row[1]),
    //                 'created_at'=>now(),
    //                 'updated_at'=>now()
    //                             // ... Map columns from your Excel file to the table
    //             ]);
    //         }
    //         $this->completedRecords = $this->completedRecords +1;
            
    //     });

    //     // Optionally, you can delete the uploaded file after import
    //     // unlink(storage_path("app/$path"));
    //     $endtime=microtime(true);


    //     session()->flash('success', 'Data imported and table created successfully.');
     
    //     // Clear the input fields
    //     $this->reset(['file', 'tableName']);

    // }
    
      
       
       
       
}
