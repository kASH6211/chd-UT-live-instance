<?php

namespace App\Http\Livewire\Users;


use Livewire\Component;
use App\Models\User;

use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\DeptMaster;
use App\Models\StateMaster;
use App\Models\DistMaster;
use App\Models\OfficeMaster;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\notifyviaemail;
use App\Models\PortalConfiguration;
use App\Models\SubdeptMaster;
use Illuminate\Support\Str;




class Usercomponent extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    public $search = "";
    
    public $perPage = 10;
    public $viewmodal = false;
    public $newmodal = false;
    public $editmodal = false;
    public $confirmupdatemodal = false;
    public $confirmresetpassmodal=false;

    public $object;

    public $editobject;
    public $viewobject;
    public $rolelist;
    public $statelist;
    public $districtlist;
    public $deptlist;
    public $officelist;
    public $statecode ;
    public $distcode;
    public $deptcodecode;
    public $officecode ;

    public $role_id;
   
    protected function getRules()
    {
        $rules=[
        'object.role_id' => ['required'],
        'object.name' => ['required', 'string'],
        'object.email' => ['email','required','max:100','unique:users,email','regex:/^\S+@\S+\.\S+$/'],
        'object.st_Code' => ['required'],
        'object.user_id'=>['required'],
        'object.mobileno'=>['required', 'digits:10', 'numeric','regex:/^[1-9][0-9]{9}$/'],//'unique:users,mobileno'
        'object.distcode'=>'',
        'object.deptcode'=>'',
        'object.officecode'=>'', 
        ];
   
    if($this->object->role_id>2)
       {
        
          $rules['object.distcode'].='|required';
          if($this->object->role_id==4)
          {
           $rules['object.deptcode']='|required';
           $rules['object.officecode']='|required';

          }

         
       }
       //dd($rules);
       return $rules;
}
    public function mount()
    {
       // dd(Auth:user);
        
       
       
        $this->role_id=Auth::User()->role_id;
        $this->object = new User();
        $editobject = new User();
        if($this->role_id==3)
        {
            $this->rolelist = Role::whereIn('id',[Auth::user()->role_id+1,Auth::user()->role_id+2])->get();
        }
        else
        {
            $this->rolelist = Role::whereIn('id',[Auth::user()->role_id+1])->get();
         
        }
       $this->districtlist = DistMaster::all();
       $this->statelist = StateMaster::all();
       $this->statecode = Auth::user()->st_Code;
       $this->distcode = Auth::user()->distcode;
       $this->deptcodecode = Auth::user()->deptcode;
       $this->officecode = Auth::user()->officecode;
       $this->object['distcode'] = $this->distcode;
       $this->object['deptcode'] = $this->deptcodecode;
       $this->object['officecode'] = $this->officecode;
       
       //dd($this->rules);
    }

    protected function newUser()
    {
        
        $this->object = new User();  
       $this->object->role_id=$this->role_id+1;
        $this->object->st_Code= $this->statecode;
        $this->object->distcode= $this->distcode;

        if($this->role_id==3)
       {
         $this->loadDepartments();
       }
       $this->officelist=null;
    }
    public function render()
    {
        $header = [];
        if($this->role_id==1)
        {

        }
        else if($this->role_id ==2)
        {
            $header = ['User id','District','Name','Email' ,'view','Edit', 'Delete','Reset Pwd.'];
        }
        else
        {
            $header = ['User id','Office','Department', 'view','Edit', 'Delete','Reset Pwd.'];
        }
       
        $data = User::when($this->statecode, function ($query, $search) {
            return $query->where('st_Code', $this->statecode);})->when($this->distcode, function ($query, $search) {
                return $query->where('distcode', $this->distcode);})->whereIn('role_id',Auth::user()->role_id==3?[4,5]:array(Auth::user()->role_id+1))->when($this->search, function ($query, $search) {
            return $query->where('name', 'ILIKE', "%$this->search%");
        })->orderBy('id', 'DESC')->paginate($this->perPage);
        
        $data->withPath('/users');
        
        $tot = User::where('distcode', $this->distcode)->where('role_id',Auth::user()->role_id+1)->count();
        return view('livewire.users.usercomponent',["data" => $data, "header" => $header, "total" => $tot,'rolelist'=>$this->rolelist,'statelist'=>$this->statelist]);
    }

    public function loadDistricts()
    {
        $this->districtlist = DistMaster::where('st_Code',$this->object['st_Code'])->orderBy('DistName','ASC')->get();
    }
    public function loadDepartments()
    {
        $this->deptlist = DeptMaster::where('distcode',$this->object['distcode'])->orderBy('deptname','ASC')->get();
    }
     public function loadOffices()
    {
        $this->officelist = OfficeMaster::where('distcode',$this->object['distcode'])->where('deptcode',$this->object['deptcode'])->orderBy('office','ASC')->get();
    }


    public function getDeptName($deptcode)
    {
      
        $dept= DeptMaster::where('distcode' , $this->distcode)->where('deptcode' , $deptcode )->first();
        if($dept)
        $deptname= $dept->deptname;
        else
        $deptname=null;
        return $deptname;
   }
   public function getSubDeptName($deptcode,$subdeptcode)
    {
      
        $subdeptname = SubdeptMaster::find(['subdeptcode' => $subdeptcode ,'deptcode' => $deptcode ,'distcode' => $this->distcode])->first()->subdept;
        return $subdeptname;
   }
   public function getOfficeName($deptcode,$officecode)
    {
      
         $off= OfficeMaster::where('distcode' , $this->distcode)->where('deptcode' , $deptcode )->where('officecode', $officecode)->first();
        //  dd($off);
         if($off)
         $officename=$off->office;
        else
        $officename=null;
         return $officename;
   }
public function generateUserId()
{
    $roleid = $this->object['role_id'];
    $statecode = $this->object['st_Code'];
    $distcode= $this->object['distcode'];
    $deptcode= $this->object['deptcode'];
    $officecode= $this->object['officecode'];
    $finaluserid = "";

    
    
    if($roleid==1)
        {
            //Super Admin
        }
        else if($roleid==2)
        {
            //State Admin
            $count=0;
            $u = User::where('st_Code',$statecode)->where('role_id',$roleid)->orderBy('id','DESC')->first();
            if($u)
            {
             $count=intval(substr($u->user_id, -2));
            }
            
            $count= $count+1;
            if($count<10)
                $count =  '0'.$count;

            $finaluserid = $statecode."admin".$count;
            
        }
        else if($roleid==3 or $roleid==5)
        {
            //District Admin
            $count=0;
            $u = User::where('st_Code',$statecode)->whereIn('role_id',[3,5])->where('distcode',$distcode)->orderBy('id','DESC')->first();
            if($u)
            {
             $count=intval(substr($u->user_id, -2));
            }
            
            $count= $count+1;
            if($count<10)
                $count =  '0'.$count;
            if($distcode<10)
                $distcode = '0'.$distcode;
            $finaluserid = 'd'.$statecode.$distcode.$count;
        }
        else if($roleid==4)
        {
            //Office Login
            $count=0;
            $u = User::where('st_Code',$statecode)->where('role_id',$roleid)->where('distcode',$distcode)->where('deptcode',$deptcode)->where('officecode',$officecode)->orderBy('id','DESC')->first();
            if($u)
            {
             $count=intval(substr($u->user_id, -2));
            }
            $count= $count+1;
            if($count<10)
                $count =  '0'.$count;
            
            if($distcode<10)
                $distcode = '0'.$distcode;
                
            $finaluserid = $distcode.$deptcode.$officecode.$count;
            
        }
        else
        {

        }
        return $finaluserid;

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
 public function addobject()
    {   
        
        
      
        $this->object['user_id'] = $this->generateUserId();
        // $orgpwd=Str::random(8); //i fixed the password kashif
        $orgpwd="12345678"; //i fixed the password kashif
        $hash= Hash::make($orgpwd);
        $this->object['password'] =$hash;
      
        // Validator::make(
        //     $this->object,
        //     [
        //         'role_id' => ['required'],
        //         'name' => ['required', 'string'],
        //         'email' => ['required','email'],
        //         'st_Code' => ['required'],
        //         'user_id'=>['required'],
        //         'mobileno'=>['required']
        //     ],
        //     [
        //         'role_id.required' => 'Role of user is mandatory.',
        //         'name.required' => 'Name is mandatory.',
        //         'email.required' => 'Email is mandatory.',
        //     ]
        // )->validate();
       if($this->object->role_id==5 or $this->object->role_id<=3)
       {
        $this->object->deptcode=null;
        $this->object->officecode=null;

       }
        $this->validate();
        

        $this->authorize('create',$this->object);
        if($this->object->role_id==4)
        {$offic=OfficeMaster::where('distcode',$this->object->distcode)->where('deptcode',$this->object->deptcode)->where('officecode',$this->object->officecode)->first();
        $offic->user_created=$offic->user_created+1;
        $offic->save();
        }
       $this->object->save();
       //$this->object=null;

        $this->toggle('newmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'New User Added successfully!'
        ]);

        $this->emit('close-banner');

        try{
            $reason= "New office User Added to Next Gen Dise";
            $body="
            The account has been configured with the necessary access permissions and privileges accordingly . Additionally, the login credentials has been informed of our security and password policies.

            UserName: ".$this->object->user_id."
            Password: ".$orgpwd."          
                     
            Kindly Change your password after first login.";
           
            //sending email
        $this->sendemail($this->object->email,$reason,$body);  
        
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Email Sent successfully to Office'
        ]); 
        $this->emit('close-banner');
       
        }
        catch (\Exception $e) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'Could not Send Email. Check portal Configuation'
            ]);
          
            $this->emit('close-banner');
           
        }
    }

   public function viewobject($id)
   {

    $this->viewobject =User::where('id', $id)->first();
    $this->toggle('viewmodal');

   }
    public function editobject($code)
    {
        
        $data =User::where('id', $code)->first();
        
       // $this->authorize('update',$data);
        if ($data) {

            $this->editobject['name'] =  $data->name;
            $this->editobject['email'] =  $data->email;
            $this->editobject['user_id'] =  $data->user_id;
            $this->editobject['mobileno'] =  $data->mobileno;
            $this->editobject['deptcode'] = $data->deptcode;
            $this->editobject['officecode'] = $data->officecode;
            $this->editobject['id'] =  $data->id;
            $this->editobject['distcode'] = $data->distcode;
            if($this->editobject['distcode'])
            {
                $this->editobject['distname'] = $data->userdistrict->DistName;
            }
        }
        $this->toggle('editmodal');
    }
    public function Update()
    {
        //$this->authorize('update',DeptMaster::class);
        $this->editobject['distcode'] = $this->distcode;
        //dd($this->editobject);    
        Validator::make(
            $this->editobject,
            [
                
                'name' => ['required', 'string'],
                'email' => ['required','regex:/^\S+@\S+\.\S+$/'],
                'mobileno'=>['required','size:10','regex:/^[1-9][0-9]{9}$/'],
                'user_id'=>['required']
            ],
            [
                'user_id.required' => 'user is mandatory.',
                'name.required' => 'Name is mandatory.',
                'email.required' => 'Email is mandatory.',
                'mobileno.size' => 'Mobile number must be 10 digit long.',
       
            ]
        )->validate();
        $data = User::where('user_id', $this->editobject['user_id'])->first();
        //$this->authorize('update',$data);
        $data->name = $this->editobject['name'];
        $data->email = $this->editobject['email'];
        $data->mobileno = $this->editobject['mobileno'];

        
        

        $data->save();
        $this->editobject['name'] = '';
        $this->editobject['email'] = '';
        $this->editobject['user_id'] = '';




        $this->toggle('editmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Department Details Updated successfully!'
        ]);

        $this->emit('close-banner');
    }


    public function openForDeletion($id)
    {
        //$this->authorize('delete',DeptMaster::class);
        
        $data = User::where('id', $id)->first();
        $this->authorize('delete',$data);
        $this->editobject['user_id'] = $data->user_id;
        $this->editobject['name'] = $data->name;
        $this->editobject['email'] = $data->email;
        $this->editobject['mobileno'] = $data->mobileno;
        $this->editobject['deptcode'] = $data->deptcode;
        $this->editobject['officecode'] = $data->officecode;
        $this->editobject['role_id'] = $data->role_id;
        $this->editobject['id'] = $data->id;
        $this->editobject['distname']= $data->userdistrict->DistName;


        $this->toggle('confirmupdatemodal');
    }
    public function deleteRecord($code)
    {
        //$this->authorize('delete',User::class);
        //$code = $this->generateFourDigitCode($code);
        $del = User::where('id',$code)->first();
        $this->authorize('delete',$del);
        if($del->role_id==4)
        {$offic=OfficeMaster::where('distcode',$del->distcode)->where('deptcode',$del->deptcode)->where('officecode',$del->officecode)->first();
        $offic->user_created=$offic->user_created-1;
        $offic->save();
        }
        $del->delete();
        $this->editobject['user_id'] = '';
        $this->editobject['name'] = '';
        $this->editobject['email'] = '';
        $this->editobject['role_id'] = '';
        $this->editobject['id'] = '';
        
        $this->toggle('confirmupdatemodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Department Deleted Successfully!'
        ]);
        $this->emit('close-banner');
    }

    public function openForResetPassword($id)
    {
        //$this->authorize('delete',DeptMaster::class);
       
        $data = User::where('id','=',$id)->first();
        //dd($data);
        //$this->authorize('update',$data);
        $this->editobject['user_id'] = $data->user_id;
        $this->editobject['name'] = $data->name;
        
        $this->editobject['email'] = $data->email;
        $this->editobject['mobileno'] = $data->mobileno;
        $this->editobject['deptcode'] = $data->deptcode;
        $this->editobject['officecode'] = $data->officecode;
        $this->editobject['role_id'] = $data->role_id;
        $this->editobject['id'] = $data->id;
        $this->editobject['distname']= $data->userdistrict->DistName;


        $this->toggle('confirmresetpassmodal');

       

    }
   

    public function resetPassword($code)
    {
        //$this->authorize('delete',User::class);
        //$code = $this->generateFourDigitCode($code);
        $reset = User::where('id',$code)->first();
        $this->authorize('update',$reset);
        // $orgpwd=Str::random(8);
        $orgpwd="12345678";

        $hash= Hash::make($orgpwd);
        $reset->password= $hash;
        $reset->save();
        $this->toggle('confirmresetpassmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'danger',
            'message' => 'User Password is Reset  Successfully!'
        ]);
        $this->emit('close-banner');

        
        $this->object['password'] =$hash;
        
        try{
            $reason= "Reset of password for User in Next Gen Dise";
            $body="
            The account has been configured with the necessary access permissions and privileges accordingly . Additionally, the login credentials has been informed of our security and password policies.

            UserName: ".$reset->user_id."
            New Password: ".$orgpwd."          
                     
            Kindly Change your password after first login.";
           
            //sending email
        $this->sendemail($reset->email,$reason,$body);  
        
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Email Sent successfully to User'
        ]); 
        $this->emit('close-banner');
       
        }
        catch (\Exception $e) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'Could not Send Email. Check portal Configuation'
            ]);
          
            $this->emit('close-banner');
           
        }
    }

    public function createOfficeUsersBulk()
    {
        $this->authorize('createofficebulkuser',User::class);
       $officelist=OfficeMaster::where('distcode',$this->distcode)->where('EmailID','!=',NULL)->where('user_created',0)->get();
       
       if(count($officelist)>0)
       {
       
       foreach($officelist as $offic)
       {

        
            $this->newUser();
            $this->object->deptcode=$offic->deptcode;
            $this->object->officecode=$offic->officecode;
            $this->object['user_id'] = $this->generateUserId();
        // $orgpwd=Str::random(8); //i fixed the password kashif
        $orgpwd="12345678"; //i fixed the password kashif

        $hash= Hash::make($orgpwd);
        $this->object['password'] =$hash;
        $this->object['name']=$offic->office;
        $this->object['email']=$offic->EmailID;
        $this->object['mobileno']=null;
        $this->object->role_id=4;
       
        $offic->user_created=$offic->user_created+1;
       
        
        

        $this->authorize('create',$this->object);
        
        
        $this->object->save();
        $offic->save();
        
        try{
            $reason= "New office User Added to Next Gen Dise";
            $body="
            The account has been configured with the necessary access permissions and privileges accordingly . Additionally, the login credentials has been informed of our security and password policies.

            UserName: ".$this->object->user_id."
            Password: ".$orgpwd."          
                     
            Kindly Change your password after first login.";
           
            //sending email
        $this->sendemail($this->object->email,$reason,$body);  
        
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Email Sent successfully to Office'
        ]); 
        $this->emit('close-banner');
       
        }
        catch (\Exception $e) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'Could not Send Email. Check portal Configuation'
            ]);
          
            $this->emit('close-banner');
           
        }

       }
      }
      else
      {
        //dd("No new Office with email_id found of your District");
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'danger',
            'message' => 'No new office with email id found in your district.'
        ]);
      
        $this->emit('close-banner');
       
      }
    }


   public function toggle($key)
    {
        switch ($key) {

            case "viewmodal":
                $this->viewmodal = !$this->viewmodal;
                break;

            case "newmodal":
                if($this->newmodal==false)
                {
                      $this->newUser();
                }
                $this->newmodal = !$this->newmodal;
                break;
            case "editmodal":
                $this->editmodal = !$this->editmodal;
                break;
            case "confirmupdatemodal":
                $this->confirmupdatemodal = !$this->confirmupdatemodal;
                break;
            case "confirmresetpassmodal":
                $this->confirmresetpassmodal = !$this->confirmresetpassmodal;
                break;
        }
    }
}
