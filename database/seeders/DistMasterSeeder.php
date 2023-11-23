<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dist_masters')->delete();
        $dist_masters = array(
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"1",'DistName'=>"Gurdaspur",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"2",'DistName'=>"Amritsar",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"3",'DistName'=>"Tarn Taran",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"4",'DistName'=>"Kapurthala",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"5",'DistName'=>"Jalandhar",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"6",'DistName'=>"Hoshiarpur",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"7",'DistName'=>"Shahid Bhagat Singh Nagar",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"8",'DistName'=>"Ropar",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"9",'DistName'=>"S. A. S Nagar",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"10",'DistName'=>"Fatehgarh Sahib",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"11",'DistName'=>"Ludhiana",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"12",'DistName'=>"Moga",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"13",'DistName'=>"Ferozepur",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"14",'DistName'=>"Muktsar",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"15",'DistName'=>"Faridkot",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"16",'DistName'=>"Bhatinda",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"17",'DistName'=>"Mansa",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"18",'DistName'=>"Sangrur",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"19",'DistName'=>"Barnala",'pBooths'=>null,'ActiveStatus'=>"1",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"20",'DistName'=>"Patiala",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"21",'DistName'=>"Head Office",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"22",'DistName'=>"Pathankot",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"23",'DistName'=>"Fazilka",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
            array('st_Code'=>"S19",'Division_No'=>null,'DistCode'=>"24",'DistName'=>"Malerkotla",'pBooths'=>null,'ActiveStatus'=>"0",'finalcircle'=>"",'o_id'=>null,),
        

                );
        DB::table('dist_masters')->insert($dist_masters);
    }
}
