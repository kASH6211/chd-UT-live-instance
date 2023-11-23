<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('state_masters')->delete();
        $state_masters = array(
            array('statecode'=>"S19",'StateName'=>"Punjab",),
           
                );
        DB::table('state_masters')->insert($state_masters);
    }
}
