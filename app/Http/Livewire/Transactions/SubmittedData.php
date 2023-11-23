<?php

namespace App\Http\Livewire\Transactions;

use Livewire\Component;
use App\Models\OfficeLock;
use App\Models\OfficeMaster;
use App\Models\DeptMaster;
use App\Models\SubdeptMaster;
use App\Models\PollingData;
use App\Models\PollingDataPhoto;
use App\Models\PayScale;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Mail\notifyviaemail;
use App\Models\PortalConfiguration;
use Illuminate\Support\Facades\Mail;

class SubmittedData extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    public $distcode;
    public $deptcode;
    public $subdeptcode;
    public $officecode;
    public $officerecordid;
    public $viewmodal = false;
    public $final1 = false;
    public $final2 = false;
    public $returnback=false;
    public $recordid;
    public $officename;
    public $officemail;
    public $deptname;
    public $subdeptname;
    public $datesubmitted;
    public $totalemployees;
    public $males;
    public $females;
    public $exempted;
    public $available;
    public $pd;
    public $viewobject;
    public $reasonpublic;

    public function mount($id)
    {
        $this->recordid = $id;
        $lock = OfficeLock::find($id);
        $this->officerecordid= $lock->office_id;
        $this->distcode = Auth::user()->distcode;
        $this->totalemployees = $lock->employeesfinalized;
        $this->datesubmitted = $lock->created_at;
        $this->getOfficeDetails();
        Log::info('Mounting component with distcode: ' . $this->distcode);
    }
    public function getDistCode()
    {
        return $this->distcode;
    }
    public function getOfficeDetails()
    {
       $omaster = OfficeMaster::find($this->officerecordid);
       $this->officename = $omaster->office;
       $this->officemail = $omaster->EmailID;
       $this->officecode = $omaster->officecode;
       $this->deptcode = $omaster->deptcode;
       $this->subdeptcode = $omaster->subdeptcode;
       $this->deptname = $this->getDeptName($this->deptcode);
       $this->subdeptname = $this->getSubDeptName($this->subdeptcode);
       $pd = PollingData::all();
       $this->males = $pd->where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('officecode',$this->officecode)->where('sex','M')->count();
       $this->females = $pd->where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('officecode',$this->officecode)->where('sex','F')->count();
       $this->exempted = $pd->where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('officecode',$this->officecode)->where('del','d')->count();
       $this->available = $pd->where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('officecode',$this->officecode)->where('del','o')->count();

        
    }
    public function getDeptName($deptcode)
    {
        if($deptcode)
            $dept= DeptMaster::where('distcode',$this->distcode)->where('deptcode',$deptcode)->first();

        if($dept)
            return $dept->deptname;
        return null;
    }
    public function getSubDeptName($subdeptcode)
    {
        if($subdeptcode)
            $subdept= SubdeptMaster::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('subdeptcode',$subdeptcode)->first();

        if($subdept)
            return $subdept->subdept;
        return null;
    }
    public function render()
    {
        Log::info('Rendering component with distcode: ' . $this->distcode);

        $submitteddata = PollingData::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('officecode',$this->officecode)->orderBy('id','DESC')->paginate(10);
       $submitteddata->withPath('/transactions/submitted');
      
      
        return view('livewire.transactions.submitted-data',["submitteddata"=>$submitteddata]);
    }
    
    public function retrieveImage($imageid)
    {
        
      if($imageid)
      {
        $pdp =  PollingDataPhoto::where('id',$imageid)->first();
        if($pdp)
        {
           
            return 'data:image/jpeg;base64,'.stream_get_contents($pdp->empphoto);
        }
      }
        return "Photo";

    }
    public function viewrecord($id)
    {

        $this->viewobject=PollingData::find($id);
        //dd($this->viewobject);
        $this->authorize('view',$this->viewobject);
        $this->toggle('viewmodal');

    }
    public function getPayScaleTitle()
    {
        $title = PayScale::find(['PayScaleCode' => $this->viewobject->PayScaleCode, 'distcode' => $this->viewobject->distcode])->first()->PayScale;
        return $title;
    }
    public function openfinal2()
    {
        $this->toggle('final1');
        $this->toggle('final2');

    }
    public function isFinalized()
    {
        $lock = OfficeLock::find($this->recordid);
        
        if($lock && $lock->finalized ==1)
          return true;

       return false;   
    }
    public function finalize()
    {
        $lock = OfficeLock::find($this->recordid);
        $lock->finalized = 1;
        $lock->save();
        $this->toggle('final2');
        return redirect('/transactions/finalized');
    }
    public function returnToOffice()
    {
        $this->toggle('returnback');
    }
    public function sendemail($to,$reason,$body){
        //function to send email arugments are positional
        /*
        1. Header Image: Link
        2. Subject : Subject of Email Alert
        3. Reason : reason of revert back or login details
        4. Body: Body is pre formated (line breaks allowed)
        5. Footer text
        */
        $subject = PortalConfiguration::where('name','email_subject')->first()->value;
        $ceo = PortalConfiguration::where('name','footertext')->first()->value;
        $headerimage= PortalConfiguration::where('name','email_headerimage_link')->first()->value;
        
        
        $dynamicConnectionName = $this->distcode . 'smtp'; // Change this to a unique name
        config(["mailers.connections.$dynamicConnectionName" => $this->getEmailConnection()[0]]);
        config(['mail.mailers.smtp' =>$this->getEmailConnection()[0]]);
        
        Mail::to($to)->send(new notifyviaemail(
            $headerimage,
            $subject,
            $reason,
            $body,
            $ceo,
        ));
    }
    public function sendback()
    {
       // $subject="Alert Email from Next Gen Dise";
      
        $reason=  "Data returned back from DEO for editing";
        $body="Make the necessary changes or edits to the data you returned from the District Electoral Office.
        Following Discrepencies were found in your Data
        ".$this->reasonpublic;
        
        // Carefully review the edited data to ensure its accuracy and completeness.
        // Verify that all changes are accurate and properly documented.";
        $lock = OfficeLock::find($this->recordid);
        $lock->delete();
        try{
            //sending email
        $this->sendemail($this->officemail,$reason,$body);  

        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Email Sent successfully to Office'
        ]); 
        $this->emit('close-banner');
        return redirect('/transactions/submitted');
        }
        catch (\Exception $e) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'Could not Send Email. Check portal Configuation'
            ]);
          
            $this->emit('close-banner');
        }
       
        $this->toggle('returnback');
        

    }
    public function getEmailConnection()
{

    $username = PortalConfiguration::where('name','email_username')->first();
    $password = PortalConfiguration::where('name','email_password')->first();      
    $port = PortalConfiguration::where('name','email_port')->first();
    $encryption = PortalConfiguration::where('name','email_encryption')->first();    
    $transport = PortalConfiguration::where('name','email_transport')->first();    
    $host = PortalConfiguration::where('name','email_host')->first();    
    if ($username && $password) {

        $dynamicConnectionConfig = [
            'transport' => $transport->value,
            'host' => $host->value,
            'port' => intval($port->value),
            'username' => $username->value,
            'password' =>$password->value,//'tpobmoiamysenrlu',
            'encryption' => $encryption->value,
            'from' => [
                'address' => 'nextgen-dise@nic.in',
                'name' => 'Next Gen Dise',
            ],
            // ... other configuration options
        ];
        // $dynamicConnectionConfig = [
        //     'transport' => 'smtp',
        //     'host' => 'relay.nic.in',
        //     'port' => 25,
        //     'username' => 'nextgen-dise@nic.in',
        //     'password' =>'Nextgendise@2023',//'tpobmoiamysenrlu',
        //     'encryption' => 'TLS',
        //     'from' => [
        //         'address' => 'nextgen-dise@nic.in',
        //         'name' => 'Next Gen Dise',
        //     ],
        //     // ... other configuration options
        // ];

        



        try {
            // Create a dynamic database connection
            $dynamicConnectionName = $username  . 'email'; // Change this to a unique name
            config(["mailers.connections.$dynamicConnectionName" => $dynamicConnectionConfig]);
            
            if ($dynamicConnectionConfig) {
                return [$dynamicConnectionConfig];
            } else {
                return [];
            }
        } catch (\Exception $e) {

            return null;
        }
    }

    return [];
}
    public function toggle($key)
    {
        switch($key)
        {
            // case "newmodal":
            //     $this->newmodal = !$this->newmodal;
            //     break;
                case "viewmodal":
                    $this->viewmodal = !$this->viewmodal;
                    break;
                case "final1":
                    $this->final1 = !$this->final1;
                    break;
                case "final2":
                    $this->final2 = !$this->final2;
                    break;
                case "returnback":
                    $this->returnback = !$this->returnback;
                    break;
        }
    } 

}
