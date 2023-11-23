<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  
        public function run(): void
        {
            DB::table('banks')->delete();
            $banks= array(array('BankId'=>1,'BankName'=>"SBI",),
            array('BankId'=>2,'BankName'=>"PNB",),
            array('BankId'=>3,'BankName'=>"Canara Bank",),
            array('BankId'=>4,'BankName'=>"Bank of Baroda",),
    
        
        
        
        );
    DB::table('banks')->insert($banks);
    }
}
