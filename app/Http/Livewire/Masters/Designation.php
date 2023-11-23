<?php

namespace App\Http\Livewire\Masters;
use App\Models\DesignationMaster;
use App\Models\DistMaster;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ClassMaster;
use App\Models\SelectedCPMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Helpers\ExceptionHelper;

use Illuminate\Support\Facades\Validator;


class Designation extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    public $search="";
    public $distlist;
    public $perPage = 10;
    public $newmodal = false;
    public $editmodal = false;
    public $confirmupdatemodal = false;
    public $classes;
    public $selectedCP;
    public $object ;
    public $editobject ;
    public $distcode;

    public function mount()
    {
        $this->distcode = Auth::user()->distcode;
        
        $object=new DesignationMaster();
        $editobject=new DesignationMaster();
        
        $this->distlist = DistMaster::all();
        $this->classes = ClassMaster::all();
        $this->selectedCP=SelectedCPMaster::all();
        
    }
    public function render()
    {
        $this->authorize('view',DesignationMaster::class);
        $header=['Designation','Polling Duty (Class)','Counting Duty','Edit','Delete'];
        $data = DesignationMaster::where('distcode',$this->distcode)->when($this->search,function($query, $search){
                return $query->where('Designation','ILIKE',"%$this->search%");
         })->orderBy('Designation','ASC')->paginate($this->perPage);
        $data->withPath('/master/designation');
        
        $tot = DesignationMaster::where('distcode',$this->distcode)->count();
        return view('livewire.masters.designation',["data"=>$data,"header"=>$header,"total"=>$tot,"distlist"=>$this->distlist,'classlist'=>$this->classes,'selectedcplist'=>$this->selectedCP]);
    }
    public function updatedSearch()
    {
        $this->gotoPage(1); // Go back to the first page when search query changes
    }
    public function generatecodekey($code)
    {
        $district = $this->distcode;
        if($district<10)
        {
            $district = "0".$district;
        }
        return $district.$code;

    }
    public function generateFourDigitCode($key)
    {
        switch($key)
            {
                case $key<10:
                    $key = "000".$key;
                    break;
                case ($key>=10 && $key<=100):
                    $key = "00".$key;
                    break;
                case($key>=100 && $key<=1000):
                   $key = "0".$key;
                    break;
                    default:
            }
            return $key;

    }



    public function addobject()
    {
       
        $this->object['distcode'] =$this->distcode;
        Validator::make($this->object, [
            'distcode'=> ['required'],
            'Designation' => ['required', 'string'],
            'class' => ['required', 'string'],
            'SelectedCP' => ['required', 'string'],


        ],
        [
        'distcode.required' => 'Selection of District is mandatory.',
        'Designation.required' => 'Please provide a valid Designation.',
        'class.required' => 'Selection of polling duty class is mandatory.',
        'SelectedCP.required' => 'Selection of counting duty is mandatory.',

        // Add more custom messages for other rules as needed.
    ])->validate();

      $this->object['DesigCode'] = $this->generateDesigCode($this->object['distcode']);  
      $this->object['distcode_from'] = 0;
      $fourdigitdesigcode = $this->generateFourDigitCode($this->object['DesigCode']);
      $this->object['desigcodekey'] = $this->generatecodekey($fourdigitdesigcode); 
      $this->object['IncludedContractual'] = null; 
      $this->authorize('create',new DesignationMaster($this->object));
        DesignationMaster::create($this->object);
        $this->object['DesigCode']='';
        $this->object['class']='';
        $this->object['SelectedCP']='';
        $this->object['Designation']='';


        
        $this->toggle('newmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'New Designation Added successfully!'
        ]);
      
        $this->emit('close-banner');
    }
    public function generateDesigCode($district)
    {
        $desigcode = DesignationMaster::where('distcode',$district)->orderBy('DesigCode','ASC')->get('DesigCode')->last(); 
   
        if($desigcode)
        {
            $newdesigcode = intval($desigcode['DesigCode'])+1;
        
            return $newdesigcode;
        } 
        return 1;
    
        
    }
    
    public function editobject($desigcode)
    {
       $data = DesignationMaster::where('distcode',$this->distcode)->where('DesigCode',$desigcode)->first();
       $this->authorize('update',$data);
       if($data)
       {
              $this->editobject['DesigCode'] =  $desigcode;
              $this->editobject['Designation'] =  $data->Designation;
              $this->editobject['class'] =  $data->class;

              $this->editobject['SelectedCP'] =  $data->SelectedCP;    
       }
       $this->toggle('editmodal');
    }
    public function Update()
    {
       $this->editobject['distcode'] =$this->distcode;
        Validator::make($this->editobject, [
            'distcode'=> ['required'],
            'Designation' => ['required', 'string'],
            'class' => ['required'],
            'SelectedCP' => ['required', 'string'],


        ],
        [
        'distcode.required' => 'Selection of District is mandatory.',
        'Designation.required' => 'Please provide a valid Designation.',
        'class.required' => 'Selection of polling duty class is mandatory.',
        'SelectedCP.required' => 'Selection of counting duty is mandatory.',

        // Add more custom messages for other rules as needed.
    ])->validate();
       $data = DesignationMaster::where('distcode',$this->distcode)->where('DesigCode',$this->editobject['DesigCode'])->first();
       $this->authorize('update',$data);
       $data->Designation = $this->editobject['Designation'];
       $data->class = $this->editobject['class'];
       $data->SelectedCP = $this->editobject['SelectedCP'];
       
       $data->save();
       $this->editobject['DesigCode']='';
        $this->editobject['class']='';
        $this->editobject['SelectedCP']='';
        $this->editobject['Designation']='';
       
        $this->toggle('editmodal');
       $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Designation Details Updated successfully!'
        ]);
      
        $this->emit('close-banner');


    }

    public function openForDeletion($id)
    {
        
        $data = DesignationMaster::where('distcode',$this->distcode)->where('DesigCode',$id)->first();
        $this->authorize('delete',$data);
         $this->editobject['DesigCode'] = $data->DesigCode;
         $this->editobject['Designation'] = $data->Designation;
        $this->toggle('confirmupdatemodal');
    }
    public function deleteRecord($desigcode)
    {
        $del = DesignationMaster::where('distcode',$this->distcode)->where('DesigCode',$desigcode)->first();
        $this->authorize('delete',$del);
       try{
        $del->forceDelete();
       } catch (\Illuminate\Database\QueryException $e) {
        $message = ExceptionHelper::handleException($e);
        if($message = "FOREIGN_KEY_ERROR")
        {
            $message = "This designation is assigned to some user and cannot be deleted!";
        }
        else
        {
            $message = "Some error occured while processing your request.";
        }
        $this->dispatchBrowserEvent('banner-message', [
                    'style' => 'danger',
                    'message' => $message
                ]);
                $this->emit('close-banner');
                $this->toggle('confirmupdatemodal');
                return;
        }

        $this->editobject['']= null;
        $this->editobject['Desigcode'] = '';
        $this->editobject['Designation'] = '';

        $this->toggle('confirmupdatemodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Designation Deleted Successfully!'
        ]);
        $this->emit('close-banner');
    }
    public function toggle($key)
    {
        switch($key)
        {
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
