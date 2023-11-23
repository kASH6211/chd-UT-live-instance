<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeptCategSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dept_categs')->delete();
        $dept_categs = array(
            array('catcode'=>"1",'category'=>"State Government",'centrestate'=>"0",'CatAge'=>"58",),
            array('catcode'=>"2",'category'=>"Centre Government",'centrestate'=>"1",'CatAge'=>"60",),
            array('catcode'=>"3",'category'=>"State Government Banks",'centrestate'=>"0",'CatAge'=>"58",),
            array('catcode'=>"4",'category'=>"State Government PSU",'centrestate'=>"0",'CatAge'=>"58",),
            array('catcode'=>"5",'category'=>"Centre Government Banks",'centrestate'=>"1",'CatAge'=>"60",),
            array('catcode'=>"6",'category'=>"Centre Government PSU",'centrestate'=>"1",'CatAge'=>"60",),
            
                );
        DB::table('dept_categs')->insert($dept_categs);
    }
}
