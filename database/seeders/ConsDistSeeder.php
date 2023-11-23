<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsDistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cons_dists')->delete();
        $cons_dists= array(
        array('distcode'=>"19",'ac_no'=>"102",'ac_name'=>"Bhadaur",'admincontrol'=>"0",'admindistcode'=>"0",'innerpcircle'=>"",'innerpcirclef'=>"",'startpartyno'=>"1",'locpartyno'=>"0",'mostartpartyno'=>"1",'molocpartyno'=>"32",'mosurplus'=>"7",'del'=>"o",),
        array('distcode'=>"19",'ac_no'=>"103",'ac_name'=>"Barnala",'admincontrol'=>"0",'admindistcode'=>"0",'innerpcircle'=>"",'innerpcirclef'=>"",'startpartyno'=>"1",'locpartyno'=>"0",'mostartpartyno'=>"1",'molocpartyno'=>"42",'mosurplus'=>"9",'del'=>"o",),
        array('distcode'=>"19",'ac_no'=>"104",'ac_name'=>"Mehal Kalan",'admincontrol'=>"0",'admindistcode'=>"0",'innerpcircle'=>"",'innerpcirclef'=>"",'startpartyno'=>"1",'locpartyno'=>"0",'mostartpartyno'=>"1",'molocpartyno'=>"28",'mosurplus'=>"6",'del'=>"o",),
        array('distcode'=>"3","ac_no"=>"21","ac_name"=>"Tarn Taran","admincontrol"=>"0","admindistcode"=>"0","innerpcircle"=>"",'innerpcirclef'=>"",'startpartyno'=>"1",'locpartyno'=>"0",'mostartpartyno'=>"1",'molocpartyno'=>"32",'mosurplus'=>"7",'del'=>"o",),
        array('distcode'=>"3","ac_no"=>"22","ac_name"=>"Khem Karan","admincontrol"=>"0","admindistcode"=>"0","innerpcircle"=>"",'innerpcirclef'=>"",'startpartyno'=>"1",'locpartyno'=>"0",'mostartpartyno'=>"1",'molocpartyno'=>"32",'mosurplus'=>"7",'del'=>"o",),
        array('distcode'=>"3","ac_no"=>"23","ac_name"=>"Patti","admincontrol"=>"0","admindistcode"=>"0","innerpcircle"=>"",'innerpcirclef'=>"",'startpartyno'=>"1",'locpartyno'=>"0",'mostartpartyno'=>"1",'molocpartyno'=>"32",'mosurplus'=>"7",'del'=>"o",),
        array('distcode'=>"3","ac_no"=>"24","ac_name"=>"Khadoor Sahib","admincontrol"=>"0","admindistcode"=>"0","innerpcircle"=>"",'innerpcirclef'=>"",'startpartyno'=>"1",'locpartyno'=>"0",'mostartpartyno'=>"1",'molocpartyno'=>"32",'mosurplus'=>"7",'del'=>"o",),
    
    
    
    
    );
DB::table('cons_dists')->insert($cons_dists);



    }
}
