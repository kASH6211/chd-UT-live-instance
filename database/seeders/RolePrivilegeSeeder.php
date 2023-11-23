<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_privilege_mappings')->delete();
        $role_privilege = array(
                    
                    array('role_id' => "1",'privilege_id'=>"5"),
                    array('role_id' => "1",'privilege_id'=>"6"),
                    array('role_id' => "1",'privilege_id'=>"7"),
                    array('role_id' => "1",'privilege_id'=>"8"), 
                   
                    array('role_id' => "1",'privilege_id'=>"37"),
                    array('role_id' => "1",'privilege_id'=>"38"),
                    array('role_id' => "1",'privilege_id'=>"39"),
                    array('role_id' => "1",'privilege_id'=>"40"), 

                    array('role_id' => "2",'privilege_id'=>"1"),
                    array('role_id' => "2",'privilege_id'=>"2"),
                    array('role_id' => "2",'privilege_id'=>"3"),
                    array('role_id' => "2",'privilege_id'=>"4"), 
                    array('role_id' => "2",'privilege_id'=>"5"),
                    array('role_id' => "2",'privilege_id'=>"6"),
                    array('role_id' => "2",'privilege_id'=>"7"),
                    array('role_id' => "2",'privilege_id'=>"8"), 
                    // array('role_id' => "2",'privilege_id'=>"9"),
                    // array('role_id' => "2",'privilege_id'=>"10"),
                    // array('role_id' => "2",'privilege_id'=>"11"),
                    // array('role_id' => "2",'privilege_id'=>"12"),
                    // array('role_id' => "2",'privilege_id'=>"13"),
                    // array('role_id' => "2",'privilege_id'=>"14"),
                    // array('role_id' => "2",'privilege_id'=>"15"),
                    // array('role_id' => "2",'privilege_id'=>"16"),
                    // // array('role_id' => "2",'privilege_id'=>"17"),
                    // // array('role_id' => "2",'privilege_id'=>"18"),
                    // // array('role_id' => "2",'privilege_id'=>"19"),
                    // // array('role_id' => "2",'privilege_id'=>"20"), 
                    // array('role_id' => "2",'privilege_id'=>"21"),
                    // array('role_id' => "2",'privilege_id'=>"22"),
                    // array('role_id' => "2",'privilege_id'=>"23"),
                    // array('role_id' => "2",'privilege_id'=>"24"), 
                    // array('role_id' => "2",'privilege_id'=>"25"),
                    // array('role_id' => "2",'privilege_id'=>"26"),
                    // array('role_id' => "2",'privilege_id'=>"27"),
                    // array('role_id' => "2",'privilege_id'=>"28"), 
                    // array('role_id' => "2",'privilege_id'=>"29"),
                    // array('role_id' => "2",'privilege_id'=>"30"),
                    // array('role_id' => "2",'privilege_id'=>"31"),
                    // array('role_id' => "2",'privilege_id'=>"32"), 
                    // array('role_id' => "2",'privilege_id'=>"33"),
                    // array('role_id' => "2",'privilege_id'=>"34"),
                    // array('role_id' => "2",'privilege_id'=>"35"),
                    // array('role_id' => "2",'privilege_id'=>"36"),
                    array('role_id' => "2",'privilege_id'=>"54"),
                    array('role_id' => "2",'privilege_id'=>"55"),
                    
                    array('role_id' => "3",'privilege_id'=>"1"),
                    array('role_id' => "3",'privilege_id'=>"2"),
                    array('role_id' => "3",'privilege_id'=>"3"),
                    array('role_id' => "3",'privilege_id'=>"4"), 
                    array('role_id' => "3",'privilege_id'=>"5"),
                    array('role_id' => "3",'privilege_id'=>"6"),
                    array('role_id' => "3",'privilege_id'=>"7"),
                    array('role_id' => "3",'privilege_id'=>"8"), 
                    array('role_id' => "3",'privilege_id'=>"9"),
                    array('role_id' => "3",'privilege_id'=>"10"),
                    array('role_id' => "3",'privilege_id'=>"11"),
                    array('role_id' => "3",'privilege_id'=>"12"),
                    array('role_id' => "3",'privilege_id'=>"13"),
                    array('role_id' => "3",'privilege_id'=>"14"),
                    array('role_id' => "3",'privilege_id'=>"15"),
                    array('role_id' => "3",'privilege_id'=>"16"),
                    // array('role_id' => "3",'privilege_id'=>"17"),
                    // array('role_id' => "3",'privilege_id'=>"18"),
                    // array('role_id' => "3",'privilege_id'=>"19"),
                    // array('role_id' => "3",'privilege_id'=>"20"), 
                    array('role_id' => "3",'privilege_id'=>"21"),
                    array('role_id' => "3",'privilege_id'=>"22"),
                    array('role_id' => "3",'privilege_id'=>"23"),
                    array('role_id' => "3",'privilege_id'=>"24"), 
                    array('role_id' => "3",'privilege_id'=>"25"),
                    array('role_id' => "3",'privilege_id'=>"26"),
                    array('role_id' => "3",'privilege_id'=>"27"),
                    array('role_id' => "3",'privilege_id'=>"28"), 
                    array('role_id' => "3",'privilege_id'=>"29"),
                    array('role_id' => "3",'privilege_id'=>"30"),
                    array('role_id' => "3",'privilege_id'=>"31"),
                    array('role_id' => "3",'privilege_id'=>"32"), 
                    array('role_id' => "3",'privilege_id'=>"33"),
                    array('role_id' => "3",'privilege_id'=>"34"),
                    array('role_id' => "3",'privilege_id'=>"35"),
                    array('role_id' => "3",'privilege_id'=>"36"),
                    array('role_id' => "3",'privilege_id'=>"43"),
                    array('role_id' => "3",'privilege_id'=>"44"),
                    array('role_id' => "3",'privilege_id'=>"45"),
                    array('role_id' => "3",'privilege_id'=>"46"),
                    array('role_id' => "3",'privilege_id'=>"47"),
                    array('role_id' => "3",'privilege_id'=>"48"),
                    array('role_id' => "3",'privilege_id'=>"49"),
                    array('role_id' => "3",'privilege_id'=>"50"),
                    array('role_id' => "3",'privilege_id'=>"51"),
                    array('role_id' => "3",'privilege_id'=>"52"),
                    array('role_id' => "3",'privilege_id'=>"53"),
                    array('role_id' => "3",'privilege_id'=>"56"),
                    array('role_id' => "3",'privilege_id'=>"57"),
                    array('role_id' => "3",'privilege_id'=>"58"),
                    array('role_id' => "3",'privilege_id'=>"59"),
                    array('role_id' => "3",'privilege_id'=>"60"),
                    array('role_id' => "3",'privilege_id'=>"17"),

                     
                    array('role_id' => "4",'privilege_id'=>"17"),
                    array('role_id' => "4",'privilege_id'=>"18"),
                    array('role_id' => "4",'privilege_id'=>"19"),
                    array('role_id' => "4",'privilege_id'=>"20"),
                    array('role_id' => "4",'privilege_id'=>"41"),
                    array('role_id' => "4",'privilege_id'=>"42"),



//Masters Role Privileges start here
                    
                    array('role_id' => "5",'privilege_id'=>"9"),
                    array('role_id' => "5",'privilege_id'=>"10"),
                    array('role_id' => "5",'privilege_id'=>"11"),
                    array('role_id' => "5",'privilege_id'=>"12"),
                    array('role_id' => "5",'privilege_id'=>"13"),
                    array('role_id' => "5",'privilege_id'=>"14"),
                    array('role_id' => "5",'privilege_id'=>"15"),
                    array('role_id' => "5",'privilege_id'=>"16"),
                    // array('role_id' => "5",'privilege_id'=>"17"),
                    // array('role_id' => "5",'privilege_id'=>"18"),
                    // array('role_id' => "5",'privilege_id'=>"19"),
                    // array('role_id' => "5",'privilege_id'=>"20"), 
                    array('role_id' => "5",'privilege_id'=>"21"),
                    array('role_id' => "5",'privilege_id'=>"22"),
                    array('role_id' => "5",'privilege_id'=>"23"),
                    array('role_id' => "5",'privilege_id'=>"24"), 
                    array('role_id' => "5",'privilege_id'=>"25"),
                    array('role_id' => "5",'privilege_id'=>"26"),
                    array('role_id' => "5",'privilege_id'=>"27"),
                    array('role_id' => "5",'privilege_id'=>"28"), 
                    array('role_id' => "5",'privilege_id'=>"29"),
                    array('role_id' => "5",'privilege_id'=>"30"),
                    array('role_id' => "5",'privilege_id'=>"31"),
                    array('role_id' => "5",'privilege_id'=>"32"), 
                    array('role_id' => "5",'privilege_id'=>"33"),
                    array('role_id' => "5",'privilege_id'=>"34"),
                    array('role_id' => "5",'privilege_id'=>"35"),
                    array('role_id' => "5",'privilege_id'=>"36"),
                   

                   
                   
                );
        DB::table('role_privilege_mappings')->insert($role_privilege);
    }
}
