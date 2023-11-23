<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('class_masters')->delete();
        $classes_master= array(
            array('class'=>"1",'description'=>"PRO"),
            array('class'=>"2",'description'=>"APRO"),
            array('class'=>"3",'description'=>"PO"),
            array('class'=>"4",'description'=>"Supervisor"),
            array('class'=>"5",'description'=>"Micro Observer"),
            array('class'=>"6",'description'=>"Zonal Officer"),
            array('class'=>"7",'description'=>"Sector Officer"),
            array('class'=>"8",'description'=>"Counting Supervisor"),
            array('class'=>"9",'description'=>"Counting Assistant"),
            array('class'=>"10",'description'=>"RO"),
            array('class'=>"11",'description'=>"BLO"),
            array('class'=>"12",'description'=>"ARO-1"),
            array('class'=>"13",'description'=>"ARO-2"),
            array('class'=>"14",'description'=>"Police Party"),
            array('class'=>"15",'description'=>"Assistant Expenditure Observers"),
            array('class'=>"16",'description'=>"Video Surveillance Teams"),
            array('class'=>"17",'description'=>"Video Viewing Team"),
            array('class'=>"18",'description'=>"Accounting Teams"),
            array('class'=>"19",'description'=>"Complaint Monitoring Controll Room/Call Centre"),
            array('class'=>"20",'description'=>"Media Certification & Monitoring Committee"),
            array('class'=>"21",'description'=>"Flying Squards"),
            array('class'=>"22",'description'=>"Static Surveillance Team"),
            array('class'=>"23",'description'=>"Expenditure Monitoring Team"),
            
                );
        DB::table('class_masters')->insert($classes_master);
    }
}
