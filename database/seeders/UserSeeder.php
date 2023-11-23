<?php

namespace Database\Seeders;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $users = array(
                   array('name' => "Harminder Singh",'mobileno'=>'9090909090','email'=>'harminder.singh90@nic.in','password'=>Hash::make('12345678'),'role_id'=>1,'st_Code'=>null,'distcode'=>null,'deptcode'=>null,'user_id'=>'administrator','subdeptcode'=>null,'officecode'=>null,),
                    array('name' => "Mohammad Kashif",'mobileno'=>'9090909090','email'=>'kashif@gmail.com','password'=>Hash::make('12345678'),'role_id'=>2,'st_Code'=>"S19",'distcode'=>null,'deptcode'=>null,'user_id'=>'s19admin01','subdeptcode'=>null,'officecode'=>null,),
                    /*  array('name' => "Megha Singla",'mobileno'=>'9090909090','email'=>'megha@gmail.com','password'=>Hash::make('12345678'),'role_id'=>3,'st_Code'=>"S19",'distcode'=>19,'deptcode'=>null,'user_id'=>'ds191901','subdeptcode'=>"0001",'officecode'=>null,),
                 
                    array('name' => "Ranjodh Singh",'mobileno'=>'9090909090','email'=>'Ranjodh@gmail.com','password'=>Hash::make('12345678'),'role_id'=>3,'st_Code'=>"S19",'distcode'=>3,'deptcode'=>null,'user_id'=>'ds190301','subdeptcode'=>null,'officecode'=>null,),
                    array('name' => "Masters Role",'mobileno'=>'9090909090','email'=>'Ranjodh@gmail.com','password'=>Hash::make('12345678'),'role_id'=>5,'st_Code'=>"S19",'distcode'=>3,'deptcode'=>null,'user_id'=>'ds190302','subdeptcode'=>null,'officecode'=>null,),
                           array('name' => "Preet Singh",'mobileno'=>'9090909090','email'=>'preet@gmail.com','password'=>Hash::make('12345678'),'role_id'=>4,'st_Code'=>"S19",'distcode'=>3,'deptcode'=>"0002",'user_id'=>'030002000101','subdeptcode'=>"0001",'officecode'=>"0001",),

                    array('name' => "Gurpreet Singh",'mobileno'=>'9090909090','email'=>'gurpreet@gmail.com','password'=>Hash::make('12345678'),'role_id'=>4,'st_Code'=>"S19",'distcode'=>19,'deptcode'=>"0003",'user_id'=>'190003000101','subdeptcode'=>"0001",'officecode'=>"0001",),
                    array('name' => "satnam Singh",'mobileno'=>'9090909090','email'=>'satnam@gmail.com','password'=>Hash::make('12345678'),'role_id'=>4,'st_Code'=>"S19",'distcode'=>19,'deptcode'=>"0003",'user_id'=>'190003000201','subdeptcode'=>"0001",'officecode'=>"0002",),
              
             array('name' => "Preet Singh",'mobileno'=>'9090909090','email'=>'prewet@gmail.com','password'=>Hash::make('12345678'),'role_id'=>4,'st_Code'=>"S19",'distcode'=>3,'deptcode'=>"0002",'user_id'=>'030002002101','subdeptcode'=>"0001",'officecode'=>"0021",),
              array('name' => "Preet Singh",'mobileno'=>'9090909090','email'=>'preeet@gmail.com','password'=>Hash::make('12345678'),'role_id'=>4,'st_Code'=>"S19",'distcode'=>3,'deptcode'=>"0002",'user_id'=>'030002001901','subdeptcode'=>"0001",'officecode'=>"0019",),
              array('name' => "Preet Singh",'mobileno'=>'9090909090','email'=>'preret@gmail.com','password'=>Hash::make('12345678'),'role_id'=>4,'st_Code'=>"S19",'distcode'=>3,'deptcode'=>"0002",'user_id'=>'030002002001','subdeptcode'=>"0001",'officecode'=>"0020",),
              array('name' => "Preet Singh",'mobileno'=>'9090909090','email'=>'preteot@gmail.com','password'=>Hash::make('12345678'),'role_id'=>4,'st_Code'=>"S19",'distcode'=>3,'deptcode'=>"0010",'user_id'=>'030010000401','subdeptcode'=>"0001",'officecode'=>"0006",),
              array('name' => "Preet Singh",'mobileno'=>'9090909090','email'=>'pretet@gmail.com','password'=>Hash::make('12345678'),'role_id'=>4,'st_Code'=>"S19",'distcode'=>3,'deptcode'=>"0010",'user_id'=>'030010000601','subdeptcode'=>"0001",'officecode'=>"0006",),
              array('name' => "Preet Singh",'mobileno'=>'9090909090','email'=>'preyet@gmail.com','password'=>Hash::make('12345678'),'role_id'=>4,'st_Code'=>"S19",'distcode'=>3,'deptcode'=>"0015",'user_id'=>'030015000701','subdeptcode'=>"0001",'officecode'=>"0007",),
              array('name' => "Preet Singh",'mobileno'=>'9090909090','email'=>'prevet@gmail.com','password'=>Hash::make('12345678'),'role_id'=>4,'st_Code'=>"S19",'distcode'=>3,'deptcode'=>"0017",'user_id'=>'030017001001','subdeptcode'=>"0001",'officecode'=>"0010",),
              array('name' => "Preet Singh",'mobileno'=>'9090909090','email'=>'prexet@gmail.com','password'=>Hash::make('12345678'),'role_id'=>4,'st_Code'=>"S19",'distcode'=>3,'deptcode'=>"0018",'user_id'=>'030018001601','subdeptcode'=>"0001",'officecode'=>"0016",),
             */
                );
        DB::table('users')->insert($users);
    }
}
