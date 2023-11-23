<?php

namespace Database\Seeders;
use DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SelectedCPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('selected_c_p_masters')->delete();
        $data= array(
            array('code'=>"A",'description'=>"Counting Assistant"),
            array('code'=>"S",'description'=>"Counting Supervisor"),
            array('code'=>"N",'description'=>"Not Selected"),
                );
        DB::table('selected_c_p_masters')->insert($data);
    }
}
