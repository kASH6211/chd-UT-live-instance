<?php

namespace App\Http\Livewire\Transactions;

use App\Http\Livewire\Masters\Payscalemaster;
use App\Models\DesignationMaster;
use App\Models\PayScale;
use App\Models\PollingDataPhoto;
use Livewire\Component;
use App\Models\ConsList;
use App\Models\ConsDist;
use App\Models\DeptMaster;
use App\Models\OfficeMaster;
use App\Models\ClassMaster;
use App\Models\EmpType;
use App\Models\Bank;
use App\Models\PollingData;
use App\Models\Booth;
use App\Models\DistMaster;
use App\Models\ProAproBlo_MobileNoMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithFileUploads;

class PollingPersonnelDataEdit extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;
    public $desiglist;
    public $distcode ;
    public $deptcode;
    public $officecode;
    public $deptname;
    public $officename;
    public $classlist2;
    public $object;
    public $employeepic;
    public $employeepictemp;
    public $bloconscode;
    public $bloboothno;
    public $bloentry;
    public $cameraImageSize;
    public function messages() 
    {
        return [
        'object.distcode.required' => 'District code is required',
        'object.class.required' => 'Select As field is required.',
        'object.Name' => [
                            'required'=>'Name field is required.',
                            'regex'=>'Name field can contain only alphabets.',
                            'max'=> 'Name should not exceed :max characters'

                         ],
        'object.FName' => [
                            'required'=>'Father\Husband name field is required.',
                            'regex'=>'Father\Husband name field can contain only alphabets.',
                             'max'=> 'Father\Husband name should not exceed :max characters'

                         ],
        'object.rAddress' => ['required'=>'Home residence address and phone number field is required.','max'=>'Home residence address and phone number field should not exceed :max characters'],
        'object.HomeCons.required' => 'Residence assembly segment field is required.',
        'object.cons.required' => 'Place of posting under which assembly segment field is required.',
        'object.PayScaleCode.required' => 'Pay scale field is required.',
        'object.basicpay.required' => ['required'=>'Basic pay field is required.'],
        
        'object.office' => ['required'=>'Office name and address field is required.','max'=>'Office name and address field  should not exceed :max characters '],
        'object.category.required' => 'Class(A\B\C) field is required.',
        'object.DesigCode.required' => 'Designation field is required.',
        'object.sex.required' => 'Sex field is required.',
        'object.nativecon.required' => 'Native assembly segment field is required.',
        'object.mobileno.regex' => [
                                'required' => 'The mobile number is required.',
                                'digits' => 'The mobile number must be exactly :digits digits.',
                                'numeric' => 'The mobile number must contain only numeric characters.',
                            ],
        'object.dob.required' => 'Date of birth field is required.',
        'object.dob.before_or_equal' => 'Employee must be atleast 18 Yrs old. The :attribute must be before or equal to :date.',

        'object.retiredt.required' => 'Retirement date field is required.',
        'object.EmpTypeId.required' => 'Employee type field is required.',
       // 'employeepic.required' => 'Employee photo is required.',
        'object.emailid.regex' => [
            'email'=>'Please enter a valid email address.',
            'max'=> 'Email address should not exceed :max characters'
        ],
        'object.Remarks' => [
           
            'max'=> 'Remarks field should not exceed :max characters'
        ],
        'object.hrmscode' => [
           
            'max'=> 'HRMS code field should not exceed :max characters'
        ],
         'object.ifmscode' => [
           
            'max'=> 'IFMS code field should not exceed :max characters'
         ],
         'object.ddocode' => [
           
            'max'=> 'DDO code field should not exceed :max characters'
         ], 
          'object.IfscCode' => [
           
            'max'=> 'Bank IFSC code field should not exceed :max characters'
        ]


        
        ];
    }
        public function  rules()
        {
            // if($this->object->transferred=="T"){
            //     //dd("hello");
            //     return
            //     [
                    
            //         'object.deptcode' => 'required',
            //         'object.officecode' => 'required',
            //         'object.distcode' => 'required',
            //         'object.hrmscode'=>['required','max:6'],
            //         'object.Name' => ['required','regex:/^[A-Za-z\s]+$/','max:60'],
            //         'object.FName' => ['required','regex:/^[A-Za-z\s]+$/','max:60'],
            //         'object.sex' => 'required',
            //         'object.mobileno' => ['required', 'digits:10', 'numeric'],
            //         //'object.emailid'=>['email','nullable','max:100'],
            //         'object.dob' => ['required','before_or_equal:today'],
            //     ];
            // }
            
            return
            [
        'object.epicno' => [''],
        'object.partno' => [''],
        'object.serialno' => [''],
        'object.RegdVoterCons' => [''],
        'object.Name' => ['required','regex:/^[A-Za-z\s]+$/','max:60'],
        'object.FName' => ['required','regex:/^[A-Za-z\s]+$/','max:60'],
        'object.sex' => 'required',
        'object.mobileno' => ['required', 'digits:10', 'numeric','regex:/^[1-9][0-9]{9}$/'],
       'object.emailid'=>['email','nullable','max:100', 'regex:/^\S+@\S+\.\S+$/'],
       'object.dob' => ['required','before_or_equal:'.now()->subYears(18)->format('d-m-Y')],
        'object.retiredt' => ['required','after_or_equal:today'],
        'object.DesigCode' => 'required',
        'object.EmpTypeId' => 'required',
        'object.category' => 'required',
        'object.PayScaleCode' => 'required',
        'object.basicPay' => ['required','numeric'],
        'object.nativecon' => 'required',
        'object.HomeCons' => 'required',
        'object.cons' => 'required',
        'object.office' => ['required', 'max:60'],
        'object.rAddress' => ['required','max:60'],
        'object.excercisedElectionDuty'=>['nullable'],
        'object.class' => 'required',
        'employeepic'=>'required',
        'object.del' => 'required',
        // 'object.dt' => 'required',
        'object.deptcode' => 'required',
        'object.officecode' => 'required',
        'object.distcode' => 'required',
        'object.longLeave' => 'required',
       'object.handicap' => 'required',
       'object.Remarks'=>['nullable','max:60'],
       'object.BankId'=>['nullable'],
       'object.hrmscode'=>['nullable','max:6'],
       'object.ifmscode'=>['nullable','max:16'],
       'object.ddocode'=>['nullable','max:12'],
       'object.BankAcNo'=>['nullable','max:20','regex:/^[0-9]*$/'],
       'object.IfscCode'=>['nullable','max:20'],
       'object.transferred'=>['required'],
    //    'bloconscode'=>'required',
    //    'bloboothno'=>'required',
       
       
        //'rno', => 'required',
        
       
        
        //'SpouseWorking', => 'required',
      //  'object.excercisedElectionDuty' => 'required',
       // 'object.longLeave' => 'required',
      //  'object.handicap' => 'required',
        //'DOR', => 'required',
        //'object.BLO' => 'required',
        //'object.Remarks' => 'required',
        //'id', => 'required',
        //'login', => 'required',
        
        //'PartyNo', => 'required',
        //'POSNo', => 'required',
    // 'reserve', => 'required',
        //'cons_alot', => 'required',
        //'StateCentre', => 'required//'sendtoother', => 'required',
        //'sendreceivedist', => 'required',
        //'oldrno', => 'required',
        //'newpartyno', => 'required',
        //'selected', => 'required',
        //'transferred', => 'required',
        //'letterno', => 'required',
        //'epicno', => 'required',
        //'centrecode', => 'required',
     //   'object.emailid' => 'required',
        //'serialno', => 'required',
    // 'partno', => 'required',
        //'pan', => 'required',
        
        //'deptslno', => 'required',
        //'exportdata', => 'required',
        //'lotno', => 'required',
        //'MachineSerialNumber', => 'required',
        //'MachineName', => 'required',
        //'ProcessorID', => 'required',
        //'DataImportDate', => 'required',
        //'RegdVoterCons', => 'required',
        //'AadhaarNo', => 'required',
        //'EpicName', => 'required',
        //'EpicFhName', => 'required',
        //'EpicAadhaarNo', => 'required',
       // 'object.BankId' => 'required',
     //   'object.BankAcNo' => 'required',
     //   'object.IfscCode' => 'required',
    //    'object.ddocode' => 'required',
  //      'object.hrmscode' => 'required',
   //     'object.ifmscode' => 'required',
    ];
}

    

    public $sex = [
        ['code'=>'M','description'=>'Male'],
        ['code'=>'F','description'=>'Female'],
        ['code'=>'O','description'=>'Others'],
    ];
    public $classlist = [
        ['code'=>'A','description'=>'A'],
        ['code'=>'B','description'=>'B'],
        ['code'=>'C','description'=>'C'],
        ['code'=>'O','description'=>'Other'],

    ];
    public $payscalelist;
    public $conslist;
    public $consdistlist;
    public $boothlist;
    public $emptypelist;
    public $banklist;
    public $sugg1="";
    public $sugg2="";
    public $status=[];
    public $wstat;
    public $transfermodal = false;
    public $confirmtransfermodal = false;
   
    public $officeaddress;
    public $officecons=false;
    public $officeconsname='';
    public $selectedOption = 'computer';
    protected $listeners = ['imageFromChild'];

    public $distlist;
    public $newdist;
    public $newdept;
    public $newoffice;

    public function mount($id)
    {   
        $this->distlist=DistMaster::all();
        $this->distcode=Auth::user()->distcode;
        $this->deptcode=Auth::user()->deptcode;
        $this->officecode=Auth::user()->officecode;
        $this->object=PollingData::find($id);
        $this->bloentry=ProAproBlo_MobileNoMaster::find($this->object->photoid);
        if($this->bloentry)
        {
            $this->bloconscode=$this->bloentry->ConsCode;
            $this->bloboothno=$this->bloentry->BoothNo;
        }
        $this->object->handicap = $this->object->handicap ? true : false;
        $this->object->longLeave = $this->object->longLeave? true : false;
        $dept=DeptMaster::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->first();
        $this->deptname=$dept->deptname;
        $office=OfficeMaster::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('officecode',$this->officecode)->first();
        $this->officename=$office->office.$office->address;
        $this->object->office=$this->officename;
        if($office->office_ac)
        {
            $this->object['cons'] = $office->office_ac;
            $this->officecons =  true;
            $temp = ConsList::where('AC_NO',$office->office_ac)->first();
            $this->officeconsname = $temp['AC_NAME'];
        }
        $this->desiglist = DesignationMaster::where('distcode',$this->distcode)->orderBy('Designation','ASC')->get();
        $this->payscalelist = PayScale::where('distcode',$this->distcode)->orderBy('PayScaleCode','ASC')->get();
        $temp = ConsList::orderBy('AC_NAME','ASC')->get();
        $temp= $temp->sortByDesc(function ($item) {
            return $item->distCode == $this->distcode ? 1 : 0;
        });
        $this->conslist = collect();
        foreach($temp as $item)
        {
           
            $item['AC_NAME'] = $item['AC_NAME']." (".$item['AC_NO'].")";
          
            
            $this->conslist->push($item);
        }
        
      
        $this->classlist2=ClassMaster::all();
        $this->status=[["id"=>"N","description" => "Working"],["id"=>"R","description" => "Retired"],["id"=>"D","description" => "Deceased"],["id"=>"T","description" => "Transferred"]];
        $this->emptypelist=EmpType::all();
        $this->banklist=Bank::all();
        $this->consdistlist = ConsDist::all();
        
        $this->boothlist = Booth::where('CONSCODE',$this->bloconscode)->get();
       
        if($this->photo())
        {
            $this->employeepic='1';
        }
        
    }
    public function imageFromChild($data)
    {
        $this->employeepic = $data;

    }
    public function render()
    {
        $this->authorize('view',PollingData::class);
        return view('livewire.transactions.polling-personnel-data-edit',['desiglist'=>$this->desiglist,'sexlist'=>$this->sex,'classlist'=>$this->classlist,
    'pslist'=>$this->payscalelist,'conslist'=>$this->conslist,"status"=>$this->status]);
    }

    public function getBoothList()
    {

        $this->bloboothno=null;
        $this->boothlist=Booth::where('DISTCODE',$this->distcode)->where('CONSCODE',$this->bloconscode)->get();
 
     
    }
    public function getsuggestion($s){
        
        if($s=="desg" && $this->object->DesigCode){
            $d=DesignationMaster::where('distcode',$this->distcode)
            ->where('DesigCode',$this->object->DesigCode)->first();
            $this->sugg1=" Designation wise can be appointed as : ".$d->selectedclass->description;
        }
        if($s=="pay" && $this->object->PayScaleCode){

            $d=PayScale::where('distcode',$this->distcode)
            ->where('PayScaleCode',$this->object->PayScaleCode)->first();
            $this->sugg2=" PayScaleCode wise can be appointed as : ".$d->selectedclass->description;
        }
       
    }
    public function workstatuschange(){
        if($this->object->transferred=="T"){
           // $this->toggle('transfermodal');
        }
    }
    
  
    public function addpdobject()
    {
        if($this->object->handicap or $this->object->longLeave)
        $this->object->del='d';
        else
        $this->object->del='o';
         if($this->object->class==11)
         {
            $this->rules['bloconscode']='required|integer|gt:0';
            $this->rules['bloboothno']='required';
         }


         $this->object->Name=strtoupper($this->object->Name);
         $this->object->FName=strtoupper($this->object->FName);
         
         if($this->object->transferred!='R' and $this->object->transferred!='T' and $this->object->transferred!='D')
         { 
        $this->validate();
         }
         else
         {
            $this->object->del='d';
         }

        $this->authorize('update',$this->object);

        //if($this->object->hrmsdata==1 && $this->object->completed==0){
        //    if($this->object->transferred=='T'){
        //       $this->object->transferred ='N';
        //     }

        $this->object->completed=1;
        $this->object->save();
        if($this->object->class==11)
        {   
            if($this->bloentry==null)
            {
                $this->bloentry=new  ProAproBlo_MobileNoMaster();
                $this->bloentry->id=$this->object->photoid;
            }
        $this->bloentry->DistCode=$this->object->distcode;
        $this->bloentry->MobileNo=$this->object->mobileno;
        $this->bloentry->DeptSlNo=$this->object->deptslno;
        $this->bloentry->ConsCode=$this->bloconscode;
        $this->bloentry->BoothNo=$this->bloboothno;
       
        $this->bloentry->save();
        }
        else
        {
            if($this->bloentry)
            $this->bloentry->delete();

        }

 	if($this->object->transferred!='R' and $this->object->transferred!='T' and $this->object->transferred!='D')
        {
        $this->uploadImage($this->object->photoid);
        }       

        //dd($this->object);
       if($this->object->transferred=='T')
       {
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Employee Transferred successfully!'
        ]);
       }
       else
       {
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Employee Updated successfully!'
        ]);
       }
        $this->emit('close-banner');
        
        return redirect()->route('employeedata');
    }

    function isBase64Image($data)
{
    //Check if the data is a string and is not empty
    // if (!is_string($data) || empty($data)) {
    //     return false;
    // }

    // Check if the data is a valid Base64 encoded string
    // if (!preg_match('/^(data:image\/([a-zA-Z]+);base64,)/', $data, $matches)) {
    //     return false;
    // }

    // Get the MIME type from the matches array
    // $mime = $matches[1];

    //Check if the MIME type corresponds to a known image format
//    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp']; // Add more if needed
//    if (!in_array($mime, $allowedMimeTypes)) {
//        return false;
//    }

    return true;
}

    public function uploadImage($id)
    {
        
        
        if($this->employeepic!='1')
        {
           
            
       
            $photo=PollingDataPhoto::find($id);
            if($photo)
            {
                if($this->employeepic != null)  // This means user wants to change the picture
                {
                    if(is_object($this->employeepic) && $this->employeepic->getRealPath())
                    {
                        $this->validate([
                            'employeepic' => 'image|max:512', // Adjust max file size as needed
                        ]); 
                      
                        $photo->empphoto=base64_encode(file_get_contents($this->employeepic->getRealPath()));

                    }
                    else
                    {
                        $imageDataBinary = base64_decode($this->employeepic);
                        // Calculate the size of the binary image data
                        $this->cameraImageSize = strlen($imageDataBinary);
                        $this->validate([
                            'cameraImageSize' => 'max:512', // Adjust max file size as needed
                        ],[
                            'cameraImageSize.max' => 'The camera image size must be less than 512 kb.',
                        ]); 

                        $photo->empphoto=base64_encode(file_get_contents($this->employeepic));

                    }
                }
                $photo->save();
            }
            else
            {
              if($this->employeepic == null)
              {
                    return back()->withErrors(['employeepic' => 'Image is required when creating a new entry.']);
              }
               //dd(pg_escape_bytea(file_get_contents($this->employeepic->getRealPath())));
               $x=new PollingDataPhoto;
               $x->id=$id;
               $x->deptslno=$this->object->deptslno;
               if(is_object($this->employeepic) && $this->employeepic->getRealPath())
                    {
                        $this->validate([
                            'employeepic' => 'image|max:512', // Adjust max file size as needed
                        ]);
                        $x->empphoto=base64_encode(file_get_contents($this->employeepic->getRealPath()));


                    }
                    else
                    {
                        $imageDataBinary = base64_decode($this->employeepic);
                        // Calculate the size of the binary image data
                        $this->cameraImageSize = strlen($imageDataBinary);
                        $this->validate([
                            'cameraImageSize' => 'max:512', // Adjust max file size as needed
                        ],[
                            'cameraImageSize.max' => 'The camera image size must be less than 512 kb.',
                        ]); 

                        $x->empphoto=base64_encode(file_get_contents($this->employeepic));


                    }
               $x->save(); 
            
            }
      
       
       
       

       
       session()->flash('success', 'Image uploaded successfully.');
     }
    }


    public function photo()
    {
        $ph=PollingDataPhoto::where('id',$this->object->photoid)->first();
        return $ph;
    }

    public function retrieveImage($imageid)
    {
        
      if($imageid)
      {
        $pdp =  PollingDataPhoto::where('id',$imageid)->first();
        if($pdp)
        {
           
            return 'data:image/png;base64,'.stream_get_contents($pdp->empphoto);
        }
      }
        return null;

    }
  
    
}

        
    
