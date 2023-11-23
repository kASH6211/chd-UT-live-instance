<?php

namespace App\Http\Livewire\Import\Hrms;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use App\Imports\ExcelImports\DepartmentImport;
use App\Models\DeptMaster;
use App\Models\DistMaster;
use App\Models\OfficeMaster;
use DB;

class OfficeData extends Component
{
    use WithFileUploads;
    public $count=0;
    public $file;
    public $tableName ="hrms_offices";
    public $distcodelist=[];

    public function mount()
    {
        $this->distcodelist = DistMaster::get('id');
    }
   
    public function render()
    {
        return view('livewire.import.hrms.office-data');
    }
    public function createOfficeCode($distcode,$deptcode)
    {
       $offset = 5000;
       $code =-1;
        $office = OfficeMaster::where('distcode',$distcode)->where('deptcode',$deptcode)->where('hrmsdata',1)->orderBy('id','DESC')->first();
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
    public function getDiseDistCode($hrms_distcode)
    {
       
            $distcode = DB::table('hrms_districts')->where('hrms_distcode',$hrms_distcode)->first();
          
    
            if($distcode)
              return $distcode->dise_distcode;
            else
            return null;
        

    }
    public function getDiseDeptCode($hrms_deptcode)
    {
       
            $deptcode = DB::table('hrms_departments')->where('hrms_deptcode',$hrms_deptcode)->first();
          // $deptcodekey = $distcode.$deptcode;
            // DeptMaster::create(
            //     [
            //         'distcode'=>$distcode,
            //         'deptcode'=> $deptcode,
            //         'catcode'=>1,
            //         'deptname'=>$deptname,
            //         'address'=>"India",
            //         'CentreState'=>0,
            //         'deptcodekey'=>$deptcodekey,
            //         'hrmsdata'=>1
            //     ]
            // );

            if($deptcode)
              return $deptcode->dise_deptcode;
            else
            return null;
        

    }


    public function import()
    {
       // dd(Str::limit("GOVT SEN SEC SCHOOL BOYS FATEHGAR CHURIAN PIN:143602", 50));
        set_time_limit(600);
        //dd($this->createOfficeCode('609','5001'));
        //$this->getDiseDistCode('609');
        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);
        
        // Store the uploaded Excel file
        $path = $this->file->store('temp');
       
        // Import data from the Excel file using your custom import class
        $offices = Excel::toCollection(new DepartmentImport, $path);
      
        $offices = $offices[0];
        
        if(Schema::hasTable($this->tableName))
        {
            Schema::dropIfExists($this->tableName);
        }
        

        Schema::create($this->tableName, function ($table) {
            $table->id();
            $table->string('hrms_distcode');
            $table->integer('distcode')->nullable();
            $table->string('hrms_deptcode');
            $table->string('deptcode')->nullable();
            $table->string('hrms_officecode');
            $table->string('officecode')->nullable();
            $table->string('officename');
            $table->string('officeaddress');


            
            
            // ... Define table columns based on your data
            $table->timestamps();
        });
        // Create a new table in the database if it does not exist
        DB::table('office_masters')->where('officecode','>','5000')->delete();
        // Insert data into the newly created table
        $offices->each(function ($row) {

             $distcode=$this->getDiseDistCode($row[0]);
             $deptcode=$this->getDiseDeptCode($row[1]);
             $officecode=$this->createOfficeCode($distcode,$deptcode);
             if($distcode!=-1 and $distcode!=null and $deptcode!=null and $officecode!=null)
                {
                    $this->count=$this->count+1;
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
                    'EmailID'=>substr($row[5], 0, 50),
                    'subdeptcode'=>'0001',
                    'hrmsdata'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                                // ... Map columns from your Excel file to the table
                ]);
            }
            
        });


        foreach($this->distcodelist as $dist)
            {
                DeptMaster::where('distcode',$dist->distcode)->where('hrmsdata',1)->whereNotIn('deptcode',OfficeMaster::where('distcode',$dist->distcode)->where('hrmsdata',1)->get('deptcode'))->delete();
            }
        // Optionally, you can delete the uploaded file after import
        // unlink(storage_path("app/$path"));

        session()->flash('success', 'Data imported and table created successfully.');
     
        // Clear the input fields
        $this->reset(['file', 'tableName']);
    }
}
