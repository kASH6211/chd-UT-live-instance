<?php

namespace App\Http\Livewire\Import\Hrms;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use App\Imports\ExcelImports\DepartmentImport;
use App\Models\DeptMaster;
use App\Models\SubDeptMaster;
use App\Models\DistMaster;
use DB;

class DepartmentData extends Component
{
    use WithFileUploads;
    public $count=0;
    public $file;
    public $tableName ="hrms_departments";
    public $distcodelist=[];

    public function mount()
    {
        $this->distcodelist = DistMaster::get('id');
    }
   
    public function render()
    {
        return view('livewire.import.hrms.department-data');
    }
    public function createDeptCode($distcode)
    {
       $offset = 5000;
       $code =-1;
        $dept = DeptMaster::where('distcode',$distcode)->where('hrmsdata',1)->orderBy('id','DESC')->first();
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


    public function import()
    {
        set_time_limit(600);
        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);
        set_time_limit(600);
        
        // Store the uploaded Excel file
        $path = $this->file->store('temp');
       
        // Import data from the Excel file using your custom import class
        $departments = Excel::toCollection(new DepartmentImport, $path);
      
        $departments = $departments[0];
        
        if(Schema::hasTable($this->tableName))
        {
            Schema::dropIfExists($this->tableName);
        }
        

        Schema::create($this->tableName, function ($table) {
            $table->id();
            $table->string('hrms_deptcode');
            $table->string('hrms_department');
            $table->string('hrms_department_address');
            $table->integer('dise_deptcode');
            // ... Define table columns based on your data
            $table->timestamps();
        });
        // Create a new table in the database if it does not exist
        DB::table('subdept_masters')->delete();
        DB::table('dept_masters')->where('hrmsdata',1)->delete();
        
        // Insert data into the newly created table
        $departments->each(function ($row) {

            $this->count=$this->count+1;
            foreach($this->distcodelist as $dist)
            {
                DB::table($this->tableName)->insert([

                    'hrms_deptcode' => $row[0],
                    'hrms_department' => $row[1],
                    'hrms_department_address' => $row[2],

                    'dise_deptcode' => $this->getDiseDeptCode($dist->id,$row[1],$row[2]),
                    'created_at'=>now(),
                    'updated_at'=>now()
                                // ... Map columns from your Excel file to the table
                ]);
            }
        });

        // Optionally, you can delete the uploaded file after import
        // unlink(storage_path("app/$path"));

        session()->flash('success', 'Data imported and table created successfully.');
     
        // Clear the input fields
        $this->reset(['file', 'tableName']);
    }
}
