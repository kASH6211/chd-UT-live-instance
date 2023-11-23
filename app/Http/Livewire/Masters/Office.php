<?php

namespace App\Http\Livewire\Masters;


use Livewire\Component;
//use App\Models\PayScale;
use App\Models\DistMaster;
use App\Models\DeptMaster;
use App\Models\SubdeptMaster;
use App\Models\ConsList;
use App\Models\OfficeMaster;
use App\Models\PortalConfiguration;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use App\Mail\notifyviaemail;
use Illuminate\Support\Str;


class Office extends Component
{

    use WithPagination;
    use AuthorizesRequests;
    public $search = "";
    public $deptlist = null;
    public $conslist = [];

    public $subdeptlist = null;

    public $perPage = 10;
    public $newmodal = false;
    public $editmodal = false;
    public $confirmupdatemodal = false;
    //public $classlist;
    public $object = null;
    public $editobject;
    public $distcode;



    public function mount()
    {
        $this->distcode = Auth::user()->distcode;
        

        //$this->distlist = DistMaster::all();
        $this->deptlist = DeptMaster::where('distcode', $this->distcode)->orderBy('deptname','asc')->get();
        $temp= ConsList::where('distCode',$this->distcode)->orderBy('AC_NO', 'ASC')->get();
        foreach($temp as $item)
        {
            
            $acno = $item->AC_NO;
            if($acno<10)
            {   
                $acno = "0".$acno;
            }
            $item->AC_NAME =  $item->AC_NAME." (".$acno.")";
            array_push($this->conslist,$item);
        }
       


        // $this->classlist = ClassMaster::all();

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
                // ... other configuration options
            ];



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
    public function loadSubDepts()
    {
        if ($this->object && $this->object['deptcode']) {
            $this->subdeptlist = SubdeptMaster::where('distcode', $this->distcode)->where('deptcode', $this->object['deptcode'])->orderBy('subdept','asc')->get();
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->authorize('view', OfficeMaster::class);
        $header = ['Office', 'Department', 'Sub-department', 'Office Address', 'Constituency', 'EmailID', 'Edit', 'Delete'];

        if ($this->distcode) {
            $data =  OfficeMaster::where('distcode', $this->distcode)->when($this->search, function ($query, $search) {
                return $query->where('office', 'ILIKE', "%$this->search%");
            })->orderBy('id', 'DESC')->paginate($this->perPage);
            $data->withPath('/master/office');
            $tot =  OfficeMaster::where('distcode', $this->distcode)->get()->count();
        } else {
            $data = OfficeMaster::when($this->search, function ($query, $search) {
                return $query->where('office', 'LIKE', "%$this->search%");
            })->orderBy('office', 'DESC')->paginate($this->perPage);
            $data->withPath('/master/office');
            $tot = OfficeMaster::all()->count();
        }
        return view('livewire.masters.office', ["data" => $data, "header" => $header, "total" => $tot]);
    }
    public function getSubDeptName($deptcode, $subdeptcode)
    {
        if ($subdeptcode) {
            $subdept = SubdeptMaster::where('distcode', $this->distcode)->where('deptcode', $deptcode)->where('subdeptcode', $subdeptcode)->first();

            if ($subdept)
                return $subdept->subdept;
        }
        return null;
    }

    public function getDeptName($deptcode)
    {
        if ($deptcode)
            $dept = DeptMaster::where('distcode', $this->distcode)->where('deptcode', $deptcode)->first();

        if ($dept)
            return $dept->deptname;
        return null;
    }
    public function addobject()
    {




        // $conslist=ConsList::where('AC_NO',$this->object['ac_no'])->get()->first();

        $this->object['distcode'] = $this->distcode;

        Validator::make(
            $this->object,
            [

                'deptcode' => ['required', 'string'],
                'subdeptcode' => ['required', 'string'],
                'office' => ['required', 'string'],
                'address' => ['required', 'string'],
                'office_ac' => ['required'],
                'EmailID' => ['required', 'Email'],

            ],
            [
                'deptcode.required' => 'Selection of Department is mandatory.',
                'subdeptcode.required' => 'Selection of Sub-department is mandatory.',
                'office' => 'Office Name Required.',
                'address' => 'Office Address Required.',
                'office_ac' => 'Office Assembly Constituency is required.',
                'EmailID' => 'Valid Email Address is Required.',

                // 'PayScaleCode.unique' => 'PayScaleCode.',



                // Add more custom messages for other rules as needed.
            ]
        )->validate();
        $this->object['officecode'] = $this->generateCode();
        $this->object['officecodekey'] = $this->generateofficecodekey($this->distcode, $this->object['deptcode'], $this->object['officecode']);
        $this->object['subdeptcodekey'] = $this->generatesubdeptcodekey($this->distcode, $this->object['deptcode'], $this->object['subdeptcode']);
         $to=$this->object['EmailID'];           
        $this->authorize('create', new OfficeMaster($this->object));
        OfficeMaster::create($this->object);
        $this->object['deptcode'] = '';
        $this->object['officecode'] = '';
        $this->object['office'] = '';
        $this->object['address'] = '';
        $this->object['office_ac'] = '';
        $this->object['EmailID'] = '';


        $this->toggle('newmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'New office added successfully!'
        ]);

        $this->emit('close-banner');

        // try{
        //     $reason= "New office Added to Next Gen Dise";
        //     $body="
        //     The account has been configured with the necessary access permissions and privileges accordingly . Additionally, the login credentials has been informed of our security and password policies.

        //     UserName: ".$this->object['officecodekey']."
        //     Password: ".Str::random(8).
        //     "          
        //     Kindly Change your password after first login.";

        //     //sending email
        // $this->sendemail($to,$reason,$body);  
        
        // $this->dispatchBrowserEvent('banner-message', [
        //     'style' => 'success',
        //     'message' => 'Email Sent successfully to Office'
        // ]); 
        // $this->emit('close-banner');
        // return redirect('/transactions/submitted');
        // }
        // catch (\Exception $e) {
        //     $this->dispatchBrowserEvent('banner-message', [
        //         'style' => 'danger',
        //         'message' => 'Could not Send Email. Check portal Configuation'
        //     ]);
          
        //     $this->emit('close-banner');
        // }
       
        // $this->toggle('returnback');
    }

    public function editobject($code)
    {
        $data = OfficeMaster::where('id', $code)->first();
        $this->authorize('update', $data);
        if ($data) {
            $this->editobject['deptcode'] =  $data->deptcode;
            $this->editobject['subdeptcode'] =  $data->subdeptcode;

            $this->subdeptlist = SubdeptMaster::where('distcode', $this->distcode)->where('deptcode', $this->editobject['deptcode'])->get();
            $this->editobject['office'] =  $data->office;
            $this->editobject['address'] =  $data->address;
            $this->editobject['office_ac'] =  $data->office_ac;
            $this->editobject['EmailID'] =  $data->EmailID;

            $this->editobject['id'] =  $data->id;
        }
        $this->toggle('editmodal');
    }


    public function Update()
    {
       
        $this->editobject['distcode'] = $this->distcode;
        Validator::make(
            $this->editobject,
            [
                'deptcode' => ['required'],
                'office' => ['required', 'string'],
                'address' => ['required', 'string'],
                'id' => ['required'],
                'office_ac' => ['required'],
                'EmailID' => ['required', 'Email'],
            ],
            [
                'deptcode.required' => 'Selection of Department is mandatory.',
                'office.required' => 'Office Name is mandatory.',
                'address.required' => 'Office Address is mandatory.',
                'id.required' => 'id is mandatory.',
                'office_ac' => 'Office Assembly Constituency is required.',
                'EmailID' => 'Valid Email Address is Required.',


                // Add more custom messages for other rules as needed.
            ]
        )->validate();

        $data = OfficeMaster::where('id', $this->editobject['id'])->first();
        $this->authorize('update', $data);
        $data->deptcode = $this->editobject['deptcode'];
        $data->subdeptcode = $this->editobject['subdeptcode'];
        $data->office = $this->editobject['office'];
        $data->address = $this->editobject['address'];
        $data->office_ac = $this->editobject['office_ac'];
        $data->EmailID = $this->editobject['EmailID'];

        $data->officecodekey = $this->generateofficecodekey($this->distcode, $this->editobject['deptcode'], $data->officecode);
        $userkey=$data->officecodekey;
        $email=$data->EmailID;
        $data->subdeptcodekey = $this->generatesubdeptcodekey($this->distcode, $this->editobject['deptcode'], $this->editobject['subdeptcode']);


        $data->save();
        $this->editobject['id'] = '';
        $this->editobject['deptcode'] = '';
        $this->editobject['office'] = '';
        $this->editobject['address'] = '';
        $this->editobject['office_ac'] = null;
        $this->editobject['EmailID'] = '';



        $this->toggle('editmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Office Updated successfully!'
        ]);

        $this->emit('close-banner');

        // try{
           
        //     $reason= "Office Updated in Next Gen Dise";
        //     $body="
        //     The account has been configured with the necessary access permissions and privileges accordingly .
            
        //     Kindly Change your password after first login.";
           
        //     //ending email
        // $this->sendemail($email,$reason,$body);  
        
        // $this->dispatchBrowserEvent('banner-message', [
        //     'style' => 'success',
        //     'message' => 'Email Sent successfully to Office'
        // ]); 
        // $this->emit('close-banner');
       
        // }
        // catch (\Exception $e) {
            
        //     $this->dispatchBrowserEvent('banner-message', [
        //         'style' => 'danger',
        //         'message' => 'Could not Send Email. Check portal Configuation'
        //     ]);
          
        //     $this->emit('close-banner');
        // }

    }

    public function openForDeletion($id)
    {

        $data = OfficeMaster::where('id', $id)->first();
        $this->authorize('delete', $data);
           
        $this->editobject['deptcode'] =  $data->deptcode;
        $this->editobject['office'] =  $data->office;
        $this->editobject['address'] =  $data->address;
        $this->editobject['EmailID'] =  $data->EmailID;
        $this->editobject['id'] =  $data->id;
        if ($data->office_ac) {
            $this->editobject['office_ac_name'] =  $data->acname->AC_NAME;
        } else {
            $this->editobject['office_ac_name'] =  "N/A";
        }

        $this->toggle('confirmupdatemodal');
    }

    public function deleteRecord($code)
    {
        $del = OfficeMaster::where('id', $code)->first();
        $this->authorize('delete', $del);
        $del->forceDelete();
        $this->editobject['id'] = '';
        $this->editobject['deptcode'] = '';
        $this->editobject['office'] = '';
        $this->editobject['address'] = '';
        $this->editobject['office_ac'] = null;
        $this->editobject['EmailID'] = null;


        $this->toggle('confirmupdatemodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'danger',
            'message' => 'Office Removed Successfully!'
        ]);
        $this->emit('close-banner');
    }


    public function generateCode()
    {
        $code = OfficeMaster::where('distcode', $this->distcode)->where('deptcode', $this->object['deptcode'])->orderBy('officecode', 'ASC')->get('officecode')->last();

        if ($code) {
            $newcode = intval($code['officecode']) + 1;

            $newcode = $this->generateFourDigitCode($newcode);

            return $newcode;
        }

        return "0001";
    }

    public function generateFourDigitCode($key)
    {
        switch ($key) {
            case $key < 10:
                $key = "000" . $key;
                break;
            case ($key >= 10 && $key <= 100):
                $key = "00" . $key;
                break;
            case ($key >= 100 && $key <= 1000):
                $key = "0" . $key;
                break;
            default:
        }
        return $key;
    }

    public function generateofficecodekey($district, $deptcode, $officecode)
    {
        if ($district < 10) {
            $district = "0" . $district;
        }
        return $district . $deptcode . $officecode;
    }
    public function generatesubdeptcodekey($district, $deptcode, $subdeptcode)
    {
        if ($district < 10) {
            $district = "0" . $district;
        }
        return $district . $deptcode . $subdeptcode;
    }

    public function toggle($key)
    {
        switch ($key) {
            case "newmodal":
                $this->newmodal = !$this->newmodal;
                break;
            case "editmodal":
                $this->editmodal = !$this->editmodal;
                break;
            case "confirmupdatemodal":
                $this->confirmupdatemodal = !$this->confirmupdatemodal;
                break;
        }
    }
}
