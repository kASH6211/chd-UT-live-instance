<?php

namespace App\Http\Livewire\Masters;

use Livewire\Component;
use App\Models\DistMaster;
use App\Models\DeptMaster;
use App\Models\SubdeptMaster;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Subdepartmentmaster extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    public $search = "";
    public $distlist;
    public $perPage = 10;
    public $deptlist;
    public $object;
    public $newmodal = false;
    public $editmodal = false;
    public $confirmupdatemodal = false;
    public $editobject;
    public $distcode ;

    public function mount()
    {
        $this->distcode=Auth::user()->distcode ;
        $object = new SubDeptMaster();
        $editobject = new SubDeptMaster();
        $this->distlist = DistMaster::all();
        $this->deptlist = DeptMaster::where('distcode', $this->distcode)->orderBy('deptname','ASC')->get();
    }

    public function render()
    {
        $this->authorize('view',SubDeptMaster::class);
        $header = ['District', 'Department', 'Sub-department', 'Address', 'Edit', 'Delete'];
        $data = SubDeptMaster::where('distcode', $this->distcode)->when($this->search, function ($query, $search) {
            return $query->where('subdept', 'ILIKE', "%$this->search%");
        })->orderBy('id', 'DESC')->paginate($this->perPage);
        $data->withPath('/master/SubDepartment');
        $tot = SubDeptMaster::where('distcode',$this->distcode)->count();
        return view('livewire.masters.subdepartmentmaster', ["data" => $data, "header" => $header, "total" => $tot, "deptlist" => $this->deptlist]);
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

    public function getdistrictcode($district)
    {
        $district = intval($district);
        if($district<10)
        {
            $district="0".$district;
        }
        return $district;
    }

    public function addobject()
    {
        
        $this->object['distcode'] = $this->distcode;
      
        $this->object['distcode_from'] = 0;
        Validator::make(
            $this->object,
            [
                'distcode' => ['required',],
                'deptcode' => ['required', 'string'],
                //'subdeptcode' => ['required', 'string'],
                'subdept' => ['required', 'string'],
                'address' => ['required', 'string'],
                //'subdeptcodekey' => ['string', 'max:10'],
                'distcode_from' => ['integer']
            ],
            [
                'distcode.required' => 'District is mandatory.',
                'deptcode.required' => 'Department Code is mandatory.',
                'subdeptcode.required' => 'Sub-department Code is mandatory.',
                'subdept.required' => 'Sub-department Name is mandatory.',
                'address.required' => 'Sub-department Address is mandatory.',
                // Add more custom messages for other rules as needed.
            ]
        )->validate();
        $this->object['subdeptcode'] =$this->generateCode($this->distcode, $this->object['deptcode']);
        $this->object['subdeptcodekey'] = $this->getdistrictcode($this->distcode) . $this->object['deptcode']. $this->object['subdeptcode'];
        $this->authorize('create',new SubDeptMaster($this->object));
        SubDeptMaster::create($this->object);
        $this->object['distcode'] ='';
        $this->object['deptcode'] ='';
        $this->object['subdept'] ='';
        $this->object['address'] ='';
        $this->object['subdeptcode'] ='';
        $this->object['subdeptcodekey'] = '';
        $this->object['distcode_from'] = 0;

        $this->toggle('newmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'New Sub-department Added successfully!'
        ]);

        $this->emit('close-banner');
    }

    public function generateCode($district, $deptcode)
    {
        $code = SubDeptMaster::where('distcode', $district)->where('deptcode', $deptcode)->orderBy('deptcode', 'ASC')->get('subdeptcode')->last();
        $newcode=0;
        if ($code == null) {
            $newcode = 1;
        }
        else {
            $newcode = intval($code['subdeptcode']) + 1;
        }
        switch ($newcode) {
            case $newcode < 10:
                $newcode = "000" . $newcode;
                break;
            case ($newcode >= 10 && $newcode <= 100):
                $newcode = "00" . $newcode;
                break;
            case ($newcode >= 100 && $newcode <= 1000):
                $newcode = "0" . $newcode;
                break;
            default:
        }
       
        return $newcode;
    }

    public function editobject($code)
    {
        $data = SubDeptMaster::where('distcode', $this->distcode)->where('subdeptcodekey', $code)->first();
        $this->authorize('update',$data);
        if ($data) {
            $this->editobject['subdept'] =  $data->subdept;
            $this->editobject['address'] =  $data->address;
            $this->editobject['subdeptcodekey'] =  $data->subdeptcodekey;
        }
        $this->toggle('editmodal');
    }

    public function Update()
    {
        $this->editobject['distcode'] = $this->distcode;
    
        Validator::make(
            $this->editobject,
            [
                'subdept' => ['required', 'string'],
                'address' => ['required', 'string'],
            ],
            [
                'subdept.required' => 'Sub-department Name is mandatory.',
                'address.required' => 'Sub-department Address is mandatory.',
            ]
        )->validate();
   
        $data = SubDeptMaster::where('distcode', $this->distcode)->where('subdeptcodekey', $this->editobject['subdeptcodekey'])->first();
        $this->authorize('update',$data);
        $data->address = $this->editobject['address'];
        $data->subdept = $this->editobject['subdept'];
        // $temp = DeptCateg::where('catcode', $this->editobject['catcode'])->get('centrestate')->first();
        // $data->CentreState = $temp['centrestate'];
      
        $data->save();
        $this->editobject['distcode'] = '';
        $this->editobject['deptcode'] = '';
        $this->editobject['subdept'] = '';
        $this->editobject['address'] = '';
       
        $this->toggle('editmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Sub-department Details Updated successfully!'
        ]);

        $this->emit('close-banner');
    }

    public function openForDeletion($id)
    {

        $data = SubdeptMaster::where('distcode', $this->distcode)->where('subdeptcodekey', $id)->first();
        //dd($id);
        $this->authorize('delete',$data);
        
        $this->editobject['subdeptcodekey'] = $data->subdeptcodekey;
        $this->editobject['subdept'] = $data->subdept;
        $this->editobject['address'] = $data->address;
        $this->toggle('confirmupdatemodal');
    }
    public function deleteRecord($code)
    {
        $del = SubDeptMaster::where('distcode', $this->distcode)->where('subdeptcodekey', $code)->first();
        $this->authorize('delete',$del);
        $del->delete();
        $this->editobject['subdeptcodekey']='';
        $this->editobject['subdept'] = '';
        $this->editobject['address'] = '';

        $this->toggle('confirmupdatemodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Sub-department Deleted Successfully!'
        ]);
        $this->emit('close-banner');
    }
}
