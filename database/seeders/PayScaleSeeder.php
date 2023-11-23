<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PayScaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
         DB::table('pay_scales')->delete();
        $listmasters = array(
            array('distcode'=>3,'PayScaleCode'=>1,'PayScale'=>"5910-20200-1900",'class'=>3),
            array('distcode'=>3,'PayScaleCode'=>2,'PayScale'=>"5910-20200-1950",'class'=>3),
            array('distcode'=>3,'PayScaleCode'=>3,'PayScale'=>"5910-20200-2000",'class'=>3),
            array('distcode'=>3,'PayScaleCode'=>4,'PayScale'=>"10300-34800-4200",'class'=>1),
            array('distcode'=>3,'PayScaleCode'=>5,'PayScale'=>"10300-34800-3200",'class'=>2),
            array('distcode'=>3,'PayScaleCode'=>6,'PayScale'=>"5910-20200-2050",'class'=>3),
            array('distcode'=>3,'PayScaleCode'=>7,'PayScale'=>"10300-34800-4400",'class'=>1),
            array('distcode'=>3,'PayScaleCode'=>8,'PayScale'=>"10300-34800-3400",'class'=>2),
            array('distcode'=>3,'PayScaleCode'=>9,'PayScale'=>"10300-34800-4600",'class'=>1),
            array('distcode'=>3,'PayScaleCode'=>10,'PayScale'=>"10300-34800-4800",'class'=>1),
            array('distcode'=>3,'PayScaleCode'=>11,'PayScale'=>"10300-34800-5000",'class'=>1),
                );
        DB::table('pay_scales')->insert($listmasters);
    }
}
