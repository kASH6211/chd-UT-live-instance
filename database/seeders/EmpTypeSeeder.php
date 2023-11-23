<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('emp_types')->delete();
        $emp_types= array(array('EmpTypeId'=>1,'EmpTypeName'=>"Regular",),
        array('EmpTypeId'=>2,'EmpTypeName'=>"Contractual",),
        array('EmpTypeId'=>3,'EmpTypeName'=>"Adhoc",),
        array('EmpTypeId'=>4,'EmpTypeName'=>"OutSourced",),

    
    
    
    );
DB::table('emp_types')->insert($emp_types);
    }
}
