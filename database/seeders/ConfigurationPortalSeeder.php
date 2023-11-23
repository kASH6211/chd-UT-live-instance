<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationPortalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('portal_configurations')->delete();
        $rows= array(
            array('name'=>"loginpagetext",'value'=>"Chief Electoral Officer Punjab"),
            array('name'=>"footertext",'value'=>"@CEO PUNJAB"),
            array('name'=>"email_username",'value'=>"nextgendisepb@gmail.com"),
            array('name'=>"email_password",'value'=>"xvqapzivbstmlmgz"),
            array('name'=>"email_subject",'value'=>"Email Alert from Next Gen Dise"),
            array('name'=>"email_headerimage_link",'value'=>"https://ci3.googleusercontent.com/proxy/zsyw4VqgWQD1_U8zYYevu9LKXdlSwXQW4EnEBpQFqXI52KXmusXdQ0RFYNmpXKxR1mV9ZSeg8nIADLJOBwWCw-tNpdQwE9HWHfQuyRNmggmngiAScyO3l58V=s0-d-e1-ft#https://imgtr.ee/images/2023/09/14/8cc82b37d418a7aafd409bab10167d4d.png"),
            array('name'=>"email_port",'value'=>"465"),
            array('name'=>"email_encryption",'value'=>"ssl"),
            array('name'=>"email_transport",'value'=>"smtp"),
            array('name'=>"email_host",'value'=>"smtp.gmail.com"),
                );
        DB::table('portal_configurations')->insert($rows);
    }
}
