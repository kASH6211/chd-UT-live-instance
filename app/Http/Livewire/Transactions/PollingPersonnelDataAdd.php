<?php

namespace App\Http\Livewire\Transactions;
use App\Models\DesignationMaster;
use Livewire\WithFileUploads;
use App\Models\PayScale;
use Livewire\Component;
use App\Models\ConsList;
use App\Models\ConsDist;
use App\Models\Booth;
use App\Models\DeptMaster;
use App\Models\OfficeMaster;
use App\Models\ClassMaster;
use App\Models\EmpType;
use App\Models\Bank;
use App\Models\PollingData;
use App\Models\PollingDataPhoto;
use App\Models\ProAproBlo_MobileNoMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



use Illuminate\Support\Facades\Validator;
class PollingPersonnelDataAdd extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;
    public $desiglist;
    public $distcode ;
    public $deptcode ;
    public $officecode;
    public $deptname;
    public $officename;
    public $classlist2;
    public $object;
    public $employeepic;
    public $employeepictemp;
    public $bloconscode;
    public $bloboothno;
    public $sugg1="";
    public $sugg2="";
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
        'object.mobileno' => [
                                'required' => 'The mobile number is required.',
                                'digits' => 'The mobile number must be exactly :digits digits.',
                                'numeric' => 'The mobile number must contain only numeric characters.',
                            ],
        'object.dob.required' => 'Date of birth field is required.',
        'object.dob.before_or_equal' => 'Employee must be atleast 18 Yrs old. The :attribute must be before or equal to :date.',
        'object.retiredt.required' => 'Retirement date field is required.',
        'object.EmpTypeId.required' => 'Employee type field is required.',
        'employeepic.required' => 'Employee photo is required.',
        'object.emailid' => [
            'email'=>'Please enter a valid email address.',
            'max'=> 'Email address should not exceed :max characters'
        ],
        'object.Remarks' => [
           
            'max'=> 'Remarks field should not exceed :max characters'
        ],
        'object.hrmscode' => [
           
            'max'=> 'HRMS code field should not exceed :max characters',
            'unique'=>'HRMS code already exists'
        ],
         'object.ifmscode' => [
           
            'max'=> 'IFMS code field should not exceed :max characters',
            'unique'=>'IFMS code already exists'
         ],
         'object.ddocode' => [
           
            'max'=> 'DDO code field should not exceed :max characters'
         ], 
          'object.IfscCode' => [
           
            'max'=> 'Bank IFSC code field should not exceed :max characters'
        ]


        
        ];
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

    public function  rules()
    {
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
       'object.emailid'=>['email','nullable','max:100','regex:/^\S+@\S+\.\S+$/'],
       'object.dob' => ['required','before_or_equal:'.now()->subYears(18)->format('d-m-Y')],
        'object.retiredt' => ['required','after_or_equal:today'],
        'object.DesigCode' =>  [
            'required',
            function ($attribute, $value, $fail) {
                $existingRecord = PollingData::where([
                    'Name' => $this->object->Name,
                    'FName' => $this->object->FName,
                    'dob' => $this->object->dob,
                    'DesigCode' => $value,
                ])->first();

                if ($existingRecord) {
                    $fail("The combination of Name, Father\Husband Name, DoB, and Designation must be unique.");
                }
            },
        ],
    
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
        'object.dt' => 'required',
        'object.deptcode' => 'required',
        'object.officecode' => 'required',
        'object.distcode' => 'required',
        'object.longLeave' => 'required',
       'object.handicap' => 'required',
       'object.Remarks'=>['nullable','max:60'],
       'object.BankId'=>['nullable'],
       'object.hrmscode'=>['nullable','max:6','unique:polling_data,hrmscode'],
       'object.ifmscode'=>['nullable','max:16','unique:polling_data,ifmscode'],
       'object.ddocode'=>['nullable','max:12'],
       'object.BankAcNo'=>['nullable','max:20','regex:/^[0-9]*$/'],
       'object.IfscCode'=>['nullable','max:20'],
       
       'bloconscode'=>$this->object->class==11?'required|integer|gt:0':'',
          'bloboothno'=>$this->object->class==11?'required|gt:0':'',
          

         
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
   
    public $officeaddress;
    public $officecons=false;
    public $officeconsname='';
    public $selectedOption = 'computer';
    protected $listeners = ['imageFromChild'];
    
    public function mount()
    {   

        $this->distcode=Auth::user()->distcode;
 
        $this->deptcode=Auth::user()->deptcode;
        $this->officecode=Auth::user()->officecode;
        $this->object=new PollingData();   
      

        $this->object->handicap = false;
      $this->object->longLeave = false;
        
        $dept=DeptMaster::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->first();
        $this->deptname=$dept->deptname;
        $office=OfficeMaster::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('officecode',$this->officecode)->first();
        $this->officename=$office->office.' '.$office->address;
        $this->object->office=$this->officename;
        if($office->office_ac)
        {
            $this->object['cons'] = $office->office_ac;
            
            $this->officecons =  true;
           
            $temp = ConsList::where('AC_NO',$office->office_ac)->first();
            $this->officeconsname = $temp['AC_NAME']." (".$temp['AC_NO'].")";
            
        }
       
        $this->desiglist = DesignationMaster::where('distcode',$this->distcode)->orderBy('Designation','ASC')->get();
        $this->payscalelist = PayScale::where('distcode',$this->distcode)->get();
      
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
        $this->consdistlist = ConsDist::where('distcode',$this->distcode)->get();
        $this->boothlist = Booth::all();
        $this->classlist2=ClassMaster::all();
        $this->emptypelist=EmpType::all();
        $this->banklist=Bank::all();
        
        
    }
    public function imageFromChild($data)
    {
        $this->employeepic = $data;

    }
    public function render()
    {
        $this->authorize('view',PollingData::class);
        return view('livewire.transactions.polling-personnel-data-add',['desiglist'=>$this->desiglist,'sexlist'=>$this->sex,'classlist'=>$this->classlist,
    'pslist'=>$this->payscalelist,'conslist'=>$this->conslist]);
    }
    public function generatePhotoId($distcode,$deptcode,$officecode,$deptslno)
    {
        if($distcode<10)
            $distcode = '0'.$distcode;
        $deptcode = $this->addPadding($deptcode);
        $officecode = $this->addPadding($officecode);
        $deptslno = $this->addPadding($deptslno);
        $temp=$distcode.$deptcode.$officecode.$deptslno;
        return $temp;

    }
    public function addPadding($code)
    {
       $code = intval($code);
        if($code<10)
            return '000'.$code;
        else if($code>=10 && $code<100)
            return '00'.$code;
        else if($code>=100 && $code<1000)
            return '0'.$code;
        
            return $code;
    }

    public function generateDeptSlNo($distcode,$deptcode,$officecode)
    {
        $pdcount = PollingData::where('distcode',$distcode)->where('deptcode',$deptcode)->where('officecode',$officecode)->orderBy('id','DESC')->first();
        $temp=1;
        
        if($pdcount && $pdcount->deptslno!=null){
         $temp=($pdcount->deptslno+1);}
        
        return $temp;
    }

   public function getBoothList()
   {
    $this->boothlist=Booth::where('DISTCODE',$this->distcode)->where('CONSCODE',$this->bloconscode)->get();

    
   }

    public function addobject()
    {
       

        $this->object->distcode=$this->distcode;
        $this->object->deptcode=$this->deptcode;
        $this->object->officecode=$this->officecode;
        $this->object->deptslno = $this->generateDeptSlNo($this->distcode,$this->deptcode,$this->officecode);
        
        $this->object->photoid = $this->generatePhotoId($this->distcode,$this->deptcode,$this->officecode,$this->object->deptslno);
        if($this->object->handicap or $this->object->longLeave)
        $this->object->del='d';
        else
        $this->object->del='o';
        $this->object->dt=now();
       
        $this->object->Name=strtoupper($this->object->Name);
        $this->object->FName=strtoupper($this->object->FName);
        $this->object->completed =1;
        $this->validate();
        $this->authorize('create',$this->object);
        $this->object->save();
        if($this->object->class==11)
        {
        $bloentry=new ProAproBlo_MobileNoMaster();
        $bloentry->id=$this->object->photoid;
        $bloentry->DistCode=$this->object->distcode;
        $bloentry->MobileNo=$this->object->mobileno;
        $bloentry->DeptSlNo=$this->object->deptslno;
        $bloentry->ConsCode=$this->bloconscode;
        $bloentry->BoothNo=$this->bloboothno;
       
        $bloentry->save();
        }



        $this->uploadImage($this->object->photoid,$this->object->deptslno);
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'New Employee Added successfully!'
        ]);
      
        $this->emit('close-banner');

        return redirect()->route('employeedata');
       
    }
    function isBase64Image($data)
    {
    // Check if the data is a string and is not empty
    if (!is_string($data) || empty($data)) {
        return false;
    }

    // Check if the data is a valid Base64 encoded string
    if (!preg_match('/^(data:image\/([a-zA-Z]+);base64,)/', $data, $matches)) {
        return false;
    }

    // Get the MIME type from the matches array
    $mime = $matches[1];

    // Check if the MIME type corresponds to a known image format
  //  $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp']; // Add more if needed
  //  if (!in_array($mime, $allowedMimeTypes)) {
    //    return false;
   // }

    return true;
}



    public function uploadImage($id,$deptslno)
    {
        // if ($this->isBase64Image($this->employeepic)) {
        //     PollingDataPhoto::create([
        //         'id' => $id,
        //         'deptslno' => $deptslno,
        //         'empphoto'=>$this->employeepic
        //     ]);
        // }
        // else
        // {
        //     // $newimage=base64_encode(file_get_contents($this->employeepic->getRealPath()));
           
            
            // $this->validate([
            //     'employeepic' => 'image|max:512', // Adjust max file size as needed
            // ]);
            if($this->employeepic && is_object($this->employeepic) && $this->employeepic->getRealPath())
            {
                $this->validate([
                    'employeepic' => 'image|max:512', // Adjust max file size as needed
                ]);
                $newimage=base64_encode(file_get_contents($this->employeepic->getRealPath()));


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

                $newimage=base64_encode(file_get_contents($this->employeepic));


            }



            PollingDataPhoto::create([
                'id' => $id,
                'deptslno' => $deptslno,
                'empphoto'=>$newimage,
            ]);

             
       // }
       session()->flash('success', 'Image uploaded successfully.');
    }
    
   
}
