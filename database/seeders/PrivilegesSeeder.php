<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrivilegesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('privileges')->delete();
        $privileges = array(
                    array('name' => "view_distmaster",'description'=>'To view the project','type'=>'1','menutype'=>'open'),
                    array('name' => "create_distmaster",'description'=>'To create project','type'=>'1','menutype'=>'open'),
                    array('name' => "update_distmaster",'description'=>'to edit changes in project','type'=>'1','menutype'=>'open'),
                    array('name' => "delete_distmaster",'description'=>'To delete project','type'=>'1','menutype'=>'open'), 
                    array('name' => "view_user",'description'=>'To view all users','type'=>'1','menutype'=>'users'),
                    array('name' => "create_user",'description'=>'To create new user','type'=>'1','menutype'=>'users'),
                    array('name' => "update_user",'description'=>' To edit existing user','type'=>'1','menutype'=>'users'),
                    array('name' => "delete_user",'description'=>'To debar user','type'=>'1','menutype'=>'users'), 
                    array('name' => "view_consdist",'description'=>'To view all Constutuencies Mapped','type'=>'1','menutype'=>'masters'),
                    array('name' => "create_consdist",'description'=>'To create new user','type'=>'1','menutype'=>'masters'),
                    array('name' => "update_consdist",'description'=>' To edit existing user','type'=>'1','menutype'=>'masters'),
                    array('name' => "delete_consdist",'description'=>'To debar user','type'=>'1','menutype'=>'masters'), 
                    array('name' => "view_deptmaster",'description'=>'To view all Departments Mapped','type'=>'1','menutype'=>'masters'),
                    array('name' => "create_deptmaster",'description'=>'To create new user','type'=>'1','menutype'=>'masters'),
                    array('name' => "update_deptmaster",'description'=>' To edit existing user','type'=>'1','menutype'=>'masters'),
                    array('name' => "delete_deptmaster",'description'=>'To debar user','type'=>'1','menutype'=>'masters'), 
                    array('name' => "view_pollingdata",'description'=>'To view all Departments Mapped','type'=>'1','menutype'=>'transactions'),
                    array('name' => "create_pollingdata",'description'=>'To create new user','type'=>'1','menutype'=>'transactions'),
                    array('name' => "update_pollingdata",'description'=>' To edit existing user','type'=>'1','menutype'=>'transactions'),
                    array('name' => "delete_pollingdata",'description'=>'To debar user','type'=>'1','menutype'=>'transactions'), 
                    array('name' => "view_officemaster",'description'=>'To view all Departments Mapped','type'=>'1','menutype'=>'masters'),
                    array('name' => "create_officemaster",'description'=>'To create new user','type'=>'1','menutype'=>'masters'),
                    array('name' => "update_officemaster",'description'=>' To edit existing user','type'=>'1','menutype'=>'masters'),
                    array('name' => "delete_officemaster",'description'=>'To debar user','type'=>'1','menutype'=>'masters'), 
                    array('name' => "view_payscale",'description'=>'To view all Departments Mapped','type'=>'1','menutype'=>'masters'),
                    array('name' => "create_payscale",'description'=>'To create new user','type'=>'1','menutype'=>'masters'),
                    array('name' => "update_payscale",'description'=>' To edit existing user','type'=>'1','menutype'=>'masters'),
                    array('name' => "delete_payscale",'description'=>'To debar user','type'=>'1','menutype'=>'masters'), 
                    array('name' => "view_designation",'description'=>'To view all Departments Mapped','type'=>'1','menutype'=>'masters'),
                    array('name' => "create_designation",'description'=>'To create new user','type'=>'1','menutype'=>'masters'),
                    array('name' => "update_designation",'description'=>' To edit existing user','type'=>'1','menutype'=>'masters'),
                    array('name' => "delete_designation",'description'=>'To debar user','type'=>'1','menutype'=>'masters'), 
                    array('name' => "view_subdeptmaster",'description'=>'To view all Departments Mapped','type'=>'1','menutype'=>'masters'),
                    array('name' => "create_subdeptmaster",'description'=>'To create new user','type'=>'1','menutype'=>'masters'),
                    array('name' => "update_subdeptmaster",'description'=>' To edit existing user','type'=>'1','menutype'=>'masters'),
                    array('name' => "delete_subdeptmaster",'description'=>'To debar user','type'=>'1','menutype'=>'masters'), 
                    array('name' => "view_role_privilege_mapping",'description'=>'To view all Departments Mapped','type'=>'1','menutype'=>'users'),
                    array('name' => "create_role_privilege_mapping",'description'=>'To create new user','type'=>'1','menutype'=>'users'),
                    array('name' => "update_role_privilege_mapping",'description'=>' To edit existing user','type'=>'1','menutype'=>'users'),
                    array('name' => "delete_role_privilege_mapping",'description'=>'To debar user','type'=>'1','menutype'=>'users'), 
                    array('name' => "view_customizedchecklist",'description'=>'To debar user','type'=>'1','menutype'=>'reports'), 
                    array('name' => "view_undertaking",'description'=>'To debar user','type'=>'1','menutype'=>'reports'), 
                    array('name' => "submitted_offices",'description'=>'To debar user','type'=>'1','menutype'=>'transactions'), 
                    array('name' => "finalized_offices",'description'=>'To debar user','type'=>'1','menutype'=>'transactions'), 
                    array('name' => "designationmaster_report",'description'=>'To debar user','type'=>'1','menutype'=>'reports'), 
                    array('name' => "payscalemaster_report",'description'=>'To debar user','type'=>'1','menutype'=>'reports'), 
                    array('name' => "import_to_dise",'description'=>'To debar user','type'=>'1','menutype'=>'administration'), 
                    array('name' => "view_boothlocn",'description'=>'To view all Departments Mapped','type'=>'1','menutype'=>'masters'),
                    array('name' => "create_boothlocn",'description'=>'To create new user','type'=>'1','menutype'=>'masters'),
                    array('name' => "update_boothlocn",'description'=>' To edit existing user','type'=>'1','menutype'=>'masters'),
                    array('name' => "delete_boothlocn",'description'=>'To debar user','type'=>'1','menutype'=>'masters'), 
                    array('name' => "exemptionlist_report",'description'=>'To debar user','type'=>'1','menutype'=>'reports'), 
                    array('name' => "emailchecklist_report",'description'=>'To debar user','type'=>'1','menutype'=>'reports'), 
                    array('name' => "importfrom_hrms",'description'=>'To debar user','type'=>'1','menutype'=>'administration'), 
                    array('name' => "portal_configuration",'description'=>'To debar user','type'=>'1','menutype'=>'administration'), 
                    array('name' => "mark_exemptions",'description'=>' To edit existing user','type'=>'1','menutype'=>'transactions'),
                    array('name' => "view_booth",'description'=>'To view all Departments Mapped','type'=>'1','menutype'=>'masters'),
                    array('name' => "create_booth",'description'=>'To create new user','type'=>'1','menutype'=>'masters'),
                    array('name' => "update_booth",'description'=>' To edit existing user','type'=>'1','menutype'=>'masters'),
                    array('name' => "delete_booth",'description'=>'To debar user','type'=>'1','menutype'=>'masters'), 
                    
                    
                   
                );
        DB::table('privileges')->insert($privileges);
    }
}
