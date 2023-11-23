<?php

namespace App\Http\Livewire\Masters;
use App\Models\DistMaster;
use App\Models\StateMaster;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class District extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    public $statelist;
    public $search="";
    public $perPage = 10;
    public $newdistrictmodal = false;
    public $editdistrictmodal = false;
    public $confirmupdatemodal = false;
    public $editselectedDistrict = null;
    public $district = [
        "st_Code"=>"",
        "Division_No"=>null,
        "DistCode"=>"",
        "DistName"=>"",
        "pBooths"=>null,
        "ActiveStatus"=>1,
        "finalCircle"=>null,
        "id"=>null
    ];
    public $editdistrict = [
        "st_Code"=>"",
        "Division_No"=>null,
        "DistCode"=>"",
        "DistName"=>"",
        "pBooths"=>null,
        "ActiveStatus"=>1,
        "finalCircle"=>null,
        "id"=>null
    ];
    
    public function mount()
    {
        $this->statelist = StateMaster::all();
        //$this->distcode=Auth::user()->distcode ;
    }

    public function render()
    {
        $this->authorize('view',DistMaster::class);
        $header=["State","District Code","District Name",'Edit','Delete'];
        $data = DistMaster::when($this->search,function($query, $search){
                return $query->where('DistName','ILIKE',"%$this->search%");
         })->orderBy('DistCode','DESC')->paginate($this->perPage);
          $data->withPath('/master/district');
        // $data=DistMaster::orderBy('DistCode','Desc')->paginate($this->perPage); 
        // $data->withPath('/master/district');
        $tot = DistMaster::all()->count();
        return view('livewire.masters.district',["data"=>$data,"header"=>$header,"total"=>$tot,"statelist"=>$this->statelist]);
    }
    
    public function addDistrict()
    {
       
        Validator::make($this->district, [
            'st_Code' => ['required', 'string', 'max:255'],
            'DistCode' => ['required', 'numeric', 'unique:dist_masters'],
            'DistName' => ['required', 'string'],
        ],
        [
        'st_Code.required' => 'State Code is required.',
        'DistCode.required' => 'District Code is required.',
        'DistName.required' => 'Please provide a valid district name.',
        'DistCode.unique' => 'District with this code is already registered.',
        // Add more custom messages for other rules as needed.
    ])->validate();
   
    $this->authorize('create',new DistMaster($this->district));
        DistMaster::create($this->district);
        
        $this->toggle('newdistrictmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'New District Added successfully!'
        ]);
      
        $this->emit('close-banner');
    }
    public function editDistrict($districtid)
    {
       $this->editselectedDistrict = DistMaster::where('DistCode',$districtid)->first();
       if($this->editselectedDistrict)
       {
              $this->editdistrict['st_Code'] =  $this->editselectedDistrict->st_Code;
              $this->editdistrict['DistCode'] =  $this->editselectedDistrict->DistCode; 
              $this->editdistrict['DistName'] =  $this->editselectedDistrict->DistName;      
       }
       $this->toggle('editdistrictmodal');
    }
    public function Update()
    {
       //If user has not changed the primary key then primary key will be availble in the database.
       //If user has changed the primary key then new key should be unique.
        if($this->editselectedDistrict->DistCode != $this->editdistrict['DistCode'] )
        {
            Validator::make($this->editdistrict, [
            'st_Code' => ['required', 'string', 'max:255'],
            'DistCode' => ['required', 'numeric', 'unique:dist_masters'],
            'DistName' => ['required', 'string'],
        ],
        [
        'st_Code.required' => 'State Code is required.',
        'DistCode.required' => 'District Code is required.',
        'DistName.required' => 'Please provide a valid district name.',
        'DistCode.unique' => 'District with this code is already registered.',
        // Add more custom messages for other rules as needed.
    ])->validate();
    }

       $this->editselectedDistrict->st_Code = $this->editdistrict['st_Code'];
       $this->editselectedDistrict->DistCode = $this->editdistrict['DistCode'];
       $this->editselectedDistrict->DistName = $this->editdistrict['DistName'];
       //$this->authorize('update',$this->editselectedDistrict);
       $this->editselectedDistrict->save();
       $this->editselectedDistrict= null;
       $this->toggle('editdistrictmodal');
       $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'District Details Updated successfully!'
        ]);
      
        $this->emit('close-banner');


    }
    public function openForDeletion($id)
    {
         $this->editselectedDistrict = DistMaster::where('DistCode',$id)->first();
         $this->editdistrict['DistCode'] = $this->editselectedDistrict->DistCode;
         $this->editdistrict['DistName'] = $this->editselectedDistrict->DistName;
        $this->toggle('confirmupdatemodal');

    }
    public function deleteDistrict($id)
    {
        $del = DistMaster::where('DistCode',$id)->first();
        $this->authorize('delete',DistMaster::class);
        $del->forceDelete();
         $this->editselectedDistrict = null;
        $this->editdistrict['DistCode'] = null;
        $this->editdistrict['DistName'] = null;

        $this->toggle('confirmupdatemodal');
       $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'District Deleted Successfully!'
        ]);
      
        $this->emit('close-banner');

    }
    public function toggle($key)
    {
        switch($key)
        {
            case "newdistrictmodal":
                $this->newdistrictmodal = !$this->newdistrictmodal;
                break;
            case "editdistrictmodal":
                $this->editdistrictmodal = !$this->editdistrictmodal;
                break;
                case "confirmupdatemodal":
                $this->confirmupdatemodal = !$this->confirmupdatemodal;
                break;
        }
    }
}
