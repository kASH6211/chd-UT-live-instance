<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        $roles = array(
            array('name' => "Super Admin"),
            array('name' => "State Admin",),
            array('name' => "DEO (District Admin)"),
            array('name' => "Office User"),
            array('name' => "Master User"),
        );
        DB::table('roles')->insert($roles);

    }
}
