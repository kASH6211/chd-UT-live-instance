<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([

          //  BankSeeder::class,
            EmpTypeSeeder::class,
            StateMasterSeeder::class,
            //DistMasterSeeder::class,
            ConsListSeeder::class,
            DeptCategSeeder::class,
          //  DeptMasterSeeder::class, //
          //  OfficeMasterSeeder::class, //
            PrivilegesSeeder::class,
            RoleSeeder::class,
            RolePrivilegeSeeder::class,
            UserSeeder::class,
            ClassMasterSeeder::class,
            SelectedCPSeeder::class,
            //ConsDistSeeder::class,//
            // BoothLocationSeeder::class,
          //  BoothSeeder::class,
           // DesignationSeeder::class,//
           // PayScaleSeeder::class,//
            ConfigurationPortalSeeder::class,
           // SubDeptSeeder::class,//


           //  PollingDataSeeder::class,//
        
        
        ]);
    }
}
