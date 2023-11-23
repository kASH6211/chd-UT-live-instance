<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('designation_masters')->delete();
        $desig_masters = array(
            array('distcode'=>3,'DesigCode'=>1,'Designation'=>"Computer Master",'class'=>1,'SelectedCP'=>'S','desigcodekey'=>"030001",'distcode_from'=>0,'IncludedContractual'=>null,),
            array('distcode'=>3,'DesigCode'=>2,'Designation'=>"English Master",'class'=>2,'SelectedCP'=>'A','desigcodekey'=>"030002",'distcode_from'=>0,'IncludedContractual'=>null,),
            array('distcode'=>3,'DesigCode'=>3,'Designation'=>"Math Master",'class'=>3,'SelectedCP'=>'N','desigcodekey'=>"030003",'distcode_from'=>0,'IncludedContractual'=>null,),
            array('distcode'=>3,'DesigCode'=>4,'Designation'=>"Clerk",'class'=>1,'SelectedCP'=>'S','desigcodekey'=>"030004",'distcode_from'=>0,'IncludedContractual'=>null,),
            array('distcode'=>3,'DesigCode'=>5,'Designation'=>"Senior Assistant",'class'=>2,'SelectedCP'=>'A','desigcodekey'=>"030005",'distcode_from'=>0,'IncludedContractual'=>null,),
            array('distcode'=>3,'DesigCode'=>6,'Designation'=>"Superintendent",'class'=>3,'SelectedCP'=>'N','desigcodekey'=>"030006",'distcode_from'=>0,'IncludedContractual'=>null,),
            array('distcode'=>3,'DesigCode'=>7,'Designation'=>"Baildar",'class'=>1,'SelectedCP'=>'S','desigcodekey'=>"030007",'distcode_from'=>0,'IncludedContractual'=>null,),
            array('distcode'=>3,'DesigCode'=>8,'Designation'=>"Agriculture Inspector",'class'=>2,'SelectedCP'=>'A','desigcodekey'=>"030008",'distcode_from'=>0,'IncludedContractual'=>null,),
            array('distcode'=>3,'DesigCode'=>9,'Designation'=>"Chief Agriculture Officer",'class'=>3,'SelectedCP'=>'N','desigcodekey'=>"030009",'distcode_from'=>0,'IncludedContractual'=>null,),

                );
        DB::table('designation_masters')->insert($desig_masters);
    }
}
