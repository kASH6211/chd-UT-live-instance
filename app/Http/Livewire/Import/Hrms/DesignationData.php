<?php

namespace App\Http\Livewire\Import\Hrms;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use App\Imports\ExcelImports\DepartmentImport;
use App\Models\DesignationMaster;


use App\Models\DistMaster;
use DB;

class DesignationData extends Component
{
    use WithFileUploads;
    public $count=0;
    public $file;
    public $exectime;
    public $tableName ="hrms_designations";
    public $distcodelist=[];

    public function mount()
    {
        $this->distcodelist = DistMaster::get('id');
    }
   
    public function render()
    {
        return view('livewire.import.hrms.designation-data');
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
    public function getDiseDesigCode($distcode, $designation)
    {
       
        $desigcode = $this->createDesigCode($distcode);
           
            $desigcodekey = $distcode.$desigcode;
            DesignationMaster::create(
                [
                    'distcode'=>$distcode,
                    'DesigCode'=> $desigcode,
                    'Designation'=>$designation,
                    // 'SelectedCP'=>1,
                     'class'=>1,
                     'hrmsdata' => 1,
                     'SelectedCP'=>'A',
                    'distcode_from'=>0,
                    'desigcodekey'=>$desigcodekey,
                    
                ]
            );
           

       return $desigcode;
        

    }


    public function import()
    {
        set_time_limit(600);

        $strttime=microtime(true);
        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);
        
        // Store the uploaded Excel file
        $path = $this->file->store('temp');
       
        // Import data from the Excel file using your custom import class
        $designations = Excel::toCollection(new DepartmentImport, $path);
      
        $designations = $designations[0];
        
        if(Schema::hasTable($this->tableName))
        {
            Schema::dropIfExists($this->tableName);
        }
        

        Schema::create($this->tableName, function ($table) {
            $table->id();
            $table->string('hrms_desigcode');
            $table->string('hrms_designation');
           
            $table->string('dise_desigcode');
            // ... Define table columns based on your data
            $table->timestamps();
        });
        // Create a new table in the database if it does not exist
        DB::table('designation_masters')->where('hrmsdata',1)->delete();
        
        // Insert data into the newly created table
        $designations->each(function ($row) {

            $this->count=$this->count+1;
            foreach($this->distcodelist as $dist)
            {
                DB::table($this->tableName)->insert([

                    'hrms_desigcode' => $row[0],
                    'hrms_designation' => $row[1],
                    

                    'dise_desigcode' => $this->getDiseDesigCode($dist->id,$row[1]),
                    'created_at'=>now(),
                    'updated_at'=>now()
                                // ... Map columns from your Excel file to the table
                ]);
            }
        });

        // Optionally, you can delete the uploaded file after import
        // unlink(storage_path("app/$path"));
        $endtime=microtime(true);

        $this->exectime=$endtime-$strttime;

        session()->flash('success', 'Data imported and table created successfully.');
     
        // Clear the input fields
        $this->reset(['file', 'tableName']);

    }
}
