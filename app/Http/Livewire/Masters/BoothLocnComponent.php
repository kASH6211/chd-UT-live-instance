<?php

namespace App\Http\Livewire\Masters;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\DistMaster;
use App\Models\BoothLocn;
use App\Models\ConsDist;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class BoothLocnComponent extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    public $search="";
    public $filtercons=null;

    public $perPage = 50;
    public $newmodal = false;
    public $editmodal = false;
    public $confirmupdatemodal = false;
    public $object ;
    public $editobject ;
    public $distcode;
    public $consdistlist=[];
    public function mount()
    {
        $this->distcode = Auth::user()->distcode;
        
        $object=new BoothLocn();
        $this->object['URBAN'] = 0;
        $editobject=new BoothLocn();
        $temp = ConsDist::where('distcode',$this->distcode)->orderBy('ac_no','ASC')->get();
       
        foreach($temp as $item)
        {
            $acno = $item->ac_no;
            if($acno<10)
            {   
                $acno = "0".$acno;
            }
            $item->ac_name = $item->ac_name." (".$acno.")";
            array_push($this->consdistlist,$item);
        }
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $this->authorize('view',BoothLocn::class);
        $header=['Constituency','Location No.','Location Name','Category','Edit','Delete'];
        $data = BoothLocn::where('DISTCODE',$this->distcode)->when($this->filtercons,function($query, $filtercons){
            return $query->where('CONSCODE','=',$this->filtercons);
     })->when($this->search,function($query, $search){
                return $query->where('LOCN_BLDG_EN','ILIKE',"%$this->search%");
         })->orderBy('PS_LOCN_NO','DESC')->paginate($this->perPage);
        
        $data->withPath('/master/boothlocn');
        
        
        $tot = BoothLocn::where('DISTCODE',$this->distcode)->count();
        return view('livewire.masters.booth-locn-component',["data"=>$data,"header"=>$header,"total"=>$tot]);
    }

    public function addobject()
    {
       
        $this->object['DISTCODE'] =$this->distcode;
        Validator::make($this->object, [
            'DISTCODE'=> ['required'],
            'CONSCODE' => ['required'],
            'LOCN_BLDG_EN' => ['required', 'string'],
            'URBAN' => ['required'],
        ],
        [
        'DISTCODE.required' => 'Selection of District is mandatory.',
        'CONSCODE.required' => 'Please select a constituency.',
        'LOCN_BLDG_EN.required' => 'Please provide a valid Location Name.',
        'URBAN.required' => 'Selection of category is mandatory.',

        // Add more custom messages for other rules as needed.
    ])->validate();

      $this->object['PS_LOCN_NO'] = $this->generateLocationNo($this->object['DISTCODE'],$this->object['CONSCODE']);  
    //  dd($this->object);

      $this->object['DISTCODE_FROM'] = 0;
      $this->object['DEL'] = 'o';
      $this->authorize('create',new BoothLocn($this->object));
      BoothLocn::create($this->object);
      $this->filtercons = $this->object['CONSCODE'];
      $this->object['PS_LOCN_NO']="";
      $this->object['CONSCODE']="";
      $this->object['LOCN_BLDG_EN']="";
      $this->object['URBAN']=false;

        
        $this->toggle('newmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'New Location Added successfully!'
        ]);
      
        $this->emit('close-banner');
    }
    public function generateLocationNo($distcode, $conscode)
    {
        $lastlocid =null;
       
        $lastconslocation = BoothLocn::where('DISTCODE',$distcode)->where('CONSCODE',$conscode)->orderBy('id','DESC')->first();
       ;
        if($lastconslocation)
        {
            $lastlocid=$lastconslocation->PS_LOCN_NO;
        }
        if ($lastlocid)
        {
            $lastlocid = intval($lastlocid)+1;
        }
        else
        {
            $lastlocid = 1;
        }
        return "".$lastlocid;
    }

    public function editobject($id)
    {
      
       $data = BoothLocn::find($id);
       $this->authorize('update',$data);
       if($data)
       {
            $this->editobject['id'] =  $id;
            $this->editobject['LOCN_BLDG_EN'] =  $data->LOCN_BLDG_EN;
            $this->editobject['URBAN'] =  $data->URBAN;
       }
       $this->toggle('editmodal');
    }

    public function Update()
    {
       $this->editobject['DISTCODE'] =$this->distcode;
       Validator::make($this->editobject, [
            'DISTCODE'=> ['required'],
            'LOCN_BLDG_EN' => ['required', 'string'],
            'URBAN' => ['required'],
        ],
        [
        'DISTCODE.required' => 'Selection of District is mandatory.',
        'LOCN_BLDG_EN.required' => 'Please provide a valid Location Name.',
        'URBAN.required' => 'Selection of category is mandatory.',

        // Add more custom messages for other rules as needed.
    ])->validate();
       $data = BoothLocn::find($this->editobject['id']);
       $data->LOCN_BLDG_EN =$this->editobject['LOCN_BLDG_EN'];
       $data->URBAN=$this->editobject['URBAN'];  

       $this->authorize('update',$data);
       $data->save();
       $this->editobject['LOCN_BLDG_EN']='';
        $this->editobject['URBAN']='';
       
       
        $this->toggle('editmodal');
       $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Location Details Updated successfully!'
        ]);
      
        $this->emit('close-banner');


    }
    public function openForDeletion($id)
    {
        
        $data = BoothLocn::find($id);
        $this->authorize('delete',$data);
        $this->editobject['id'] = $id;
        
         $this->editobject['CONSNAME'] = $data->consname->ac_name;
         $this->editobject['DISTNAME'] = $data->distname->DistName;
         $this->editobject['LOCN_BLDG_EN'] = $data->LOCN_BLDG_EN;
         $this->editobject['PS_LOCN_NO'] = $data->PS_LOCN_NO;
         $this->editobject['URBAN'] = $data->URBAN;
        $this->toggle('confirmupdatemodal');
    }
    public function deleteRecord($id)
    {
        $del = BoothLocn::find($id);
        $this->authorize('delete',$del);
        $del->delete();
        $this->editobject['CONSNAME'] = '';
        $this->editobject['DISTNAME'] = '';
        $this->editobject['LOCN_BLDG_EN'] = '';
        $this->editobject['PS_LOCN_NO'] = '';
        $this->editobject['URBAN'] = null;

        $this->toggle('confirmupdatemodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Location Deleted Successfully!'
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
