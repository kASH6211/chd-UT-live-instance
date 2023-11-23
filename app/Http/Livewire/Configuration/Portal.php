<?php

namespace App\Http\Livewire\Configuration;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\PortalConfiguration;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DistMaster;
use App\Models\User;
use App\Imports\ExcelImports\DistrictImport;
use Illuminate\Support\Facades\Schema;


use DB;

use Livewire\Component;

class Portal extends Component
{
    use WithFileUploads;
    public $configuration;
    public $distcode;
    public $loginpagetext = "";
    public $footertext = "";
    public $email_username="";
    public $email_password="";
    public $email_subject="";
    public $email_headerimage_link="";
    public $email_port="";
    public $email_encryption="";
    public $email_transport="";
    public $email_host="";
    public $file;

    public function mount()
    {
        $this->distcode=Auth::user()->distcode;
        $this->loginpagetext = $this->getLoginText();
        $this->footertext = $this->getFooterText();
        $this->email_username = $this->getUsernameText();
        $this->email_password = $this->getPasswordText();
        $this->email_subject = $this->getSubjectText();
        $this->email_headerimage_link = $this->getHeaderImageText();
        $this->email_port = $this->getPortText();
        $this->email_encryption = $this->getEncryptionText();
        $this->email_transport = $this->getTransportText();
        $this->email_host = $this->getHostText();
    }
    public function render()
    {
        return view('livewire.configuration.portal');
    }
    public function getLoginText()
    {
        $lptext ="";
        $lpobject = PortalConfiguration::where('name','loginpagetext')->first();
        if($lpobject)
        {
            $lptext = $lpobject['value'];
        }
        return $lptext;
    }
    public function getUsernameText()
    {
        $lptext ="";
        $lpobject = PortalConfiguration::where('name','email_username')->first();
        if($lpobject)
        {
            $lptext = $lpobject['value'];
        }
        return $lptext;
    }
    public function getPasswordText()
    {
        $lptext ="";
        $lpobject = PortalConfiguration::where('name','email_password')->first();
        if($lpobject)
        {
            $lptext = $lpobject['value'];
        }
        return $lptext;
    }
    public function getSubjectText()
    {
        $lptext ="";
        $lpobject = PortalConfiguration::where('name','email_subject')->first();
        if($lpobject)
        {
            $lptext = $lpobject['value'];
        }
        return $lptext;
    }
    public function getHeaderImageText()
    {
        $lptext ="";
        $lpobject = PortalConfiguration::where('name','email_headerimage_link')->first();
        if($lpobject)
        {
            $lptext = $lpobject['value'];
        }
        return $lptext;
    }
    public function getPortText()
    {
        $lptext ="";
        $lpobject = PortalConfiguration::where('name','email_port')->first();
        if($lpobject)
        {
            $lptext = $lpobject['value'];
        }
        return $lptext;
    }
    public function getEncryptionText()
    {
        $lptext ="";
        $lpobject = PortalConfiguration::where('name','email_encryption')->first();
        if($lpobject)
        {
            $lptext = $lpobject['value'];
        }
        return $lptext;
    }
    public function getTransportText()
    {
        $lptext ="";
        $lpobject = PortalConfiguration::where('name','email_transport')->first();
        if($lpobject)
        {
            $lptext = $lpobject['value'];
        }
        return $lptext;
    }
    public function getHostText()
    {
        $lptext ="";
        $lpobject = PortalConfiguration::where('name','email_host')->first();
        if($lpobject)
        {
            $lptext = $lpobject['value'];
        }
        return $lptext;
    }
    public function getFooterText()
    {
        $lptext ="";
        $lpobject = PortalConfiguration::where('name','footertext')->first();
        if($lpobject)
        {
            $lptext = $lpobject['value'];
        }
        return $lptext;
    }

    public function updateLoginText()
    {
        $lpobject = PortalConfiguration::where('name','loginpagetext')->first();
        $lpobject->value = $this->loginpagetext;
        $lpobject->save();
        $this->emit('saved');
    }

    public function updateEmailConf()
    {
         $username = PortalConfiguration::where('name','email_username')->first();
         $password = PortalConfiguration::where('name','email_password')->first();
         $subject = PortalConfiguration::where('name','email_subject')->first();
         $headerimage= PortalConfiguration::where('name','email_headerimage_link')->first();
         $port = PortalConfiguration::where('name','email_port')->first();
         $encryption = PortalConfiguration::where('name','email_encryption')->first();
         $transport = PortalConfiguration::where('name','email_transport')->first();
         $host = PortalConfiguration::where('name','email_host')->first();
         $username->value = $this->email_username??"";
         $username->save();
         $password->value = $this->email_password??"";
         $password->save();
         $subject->value = $this->email_subject??"";
         $subject->save();
         $headerimage->value = $this->email_headerimage_link??"";
         $headerimage->save();
         $port->value = $this->email_port??"";
         $port->save();
         $encryption->value = $this->email_encryption??"";
         $encryption->save(); 
         $transport->value = $this->email_transport??"";
         $transport->save();
         $host->value = $this->email_host??"";
         $host->save();

         $this->emit('savedemail');
    }

    public function updateFooterText()
    {
        $lpobject = PortalConfiguration::where('name','footertext')->first();
        $lpobject->value = $this->footertext;
        $lpobject->save();
        $this->emit('savedfooter');
    }
    
    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);
        set_time_limit(600);
        
        // Store the uploaded Excel file
        $path = $this->file->store('temp');
       
        // Import data from the Excel file using your custom import class
        $excelfile= Excel::toCollection(new DistrictImport, $path);
        $districts =$excelfile[0]->slice(1); 
        $disedistricts = DistMaster::all();
        foreach($disedistricts as $ddis)
        {
            User::where('distcode', $ddis->DistCode)->delete();
            $ddis->delete();
        }
        $districts->each(function ($row) {
           
            $dist = new DistMaster();
            $dist->st_Code = $row[0];
            $dist->DistCode= $row[1];
            $dist->DistName= $row[2];
            $dist->ActiveStatus = 0;
            $dist->save();
           
        });
        $this->emit('savedDistricts');
    }
}
