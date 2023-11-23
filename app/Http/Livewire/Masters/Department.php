<?php

namespace App\Http\Livewire\Masters;

use App\Helpers\ExceptionHelper;
use App\Models\DeptCateg;
use App\Models\DeptMaster;

use App\Models\DistMaster;
use App\Models\SubDeptMaster;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;



class Department extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    public $search = "";
    public $distlist;
    public $catlist;
    public $perPage = 10;
    public $newmodal = false;
    public $editmodal = false;
    public $confirmupdatemodal = false;
    public $object;
    public $editobject;
    public $distcode ;
    public function mount()
    {
        $this->distcode=Auth::user()->distcode ;
        $object = new DeptMaster();
        $editobject = new DeptMaster();
        $this->distlist = DistMaster::all();
        $this->catlist = DeptCateg::all();
    }

    public function render()
    {
        $this->authorize('view',DeptMaster::class);
        $header = ['District', 'Department Name', 'Department Address', 'Department Category', 'Edit', 'Delete'];
        $data = DeptMaster::where('distcode', $this->distcode)->when($this->search, function ($query, $search) {
            return $query->where('deptname', 'ILIKE', "%$this->search%");
        })->orderBy('deptcode', 'DESC')->paginate($this->perPage);
        $data->withPath('/master/department');
        $tot = DeptMaster::where('distcode', $this->distcode)->count();
        return view('livewire.masters.department', ["data" => $data, "header" => $header, "total" => $tot, "catlist" => $this->catlist]);
    }
    public function addobject()
    {
        //$this->authorize('create',DeptMaster::class);
        $this->object['distcode'] = $this->distcode;
        $this->object['deptcode'] = $this->generateCode();
        $this->object['deptcodekey'] = $this->generatedeptcodekey($this->object['distcode'], $this->object['deptcode']);

        Validator::make(
            $this->object,
            [
                'distcode' => ['required'],
                'deptcode' => ['required'],
                'deptname' => ['required', 'string'],
                'address' => ['required', 'string'],
                'catcode' => ['required'],
            ],
            [
                'distcode.required' => 'Selection of District is mandatory.',
                'deptcode.required' => 'Department code is required.',
                'deptname.required' => 'Deparment Name is mandatory.',
                'address.required' => 'Address is mandatory.',
                'catcode.required' => 'Category is mandatory.',
            ]
        )->validate();

        $temp = DeptCateg::where('catcode', $this->object['catcode'])->get('centrestate')->first();
        $this->object['CentreState'] = $temp['centrestate'];
        $this->authorize('create',new DeptMaster($this->object));
        
        //Creating SubDepartment with same name
        
        $subdept = [
            "distcode"=>$this->object['distcode'],
            "deptcode"=>$this->object['deptcode'],
            "subdeptcode"=>"0001",
            "subdeptcodekey"=>$this->object['distcode'].$this->object['deptcode'].'0001',
            "subdept"=>$this->object['deptname'],
            "address"=>$this->object['address'],
            "distcode_from"=>0
        ];

     
        DeptMaster::create($this->object);
        SubDeptMaster::create($subdept);
        $this->object['deptcode'] = '';
        $this->object['deptname'] = '';
        $this->object['address'] = '';
        $this->object['catcode'] = '';
        $this->toggle('newmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'New Department Added successfully!'
        ]);

        $this->emit('close-banner');
    }

    public function generatedeptcodekey($district, $deptcode)
    {
        if ($district < 10) {
            $district = "0" . $district;
        }
        return $district . $deptcode;
    }
    public function generateFourDigitCode($key)
    {
        $key = intval($key);
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

    public function generateCode()
    {
        $code = DeptMaster::where('distcode', $this->distcode)->orderBy('deptcode', 'ASC')->get('deptcode')->last();

        if ($code) {
            $newcode = intval($code['deptcode']) + 1;

            $newcode = $this->generateFourDigitCode($newcode);

            return $newcode;
        }

        return "0001";
    }
    public function editobject($code)
    {
        
        $data = DeptMaster::where('distcode', $this->distcode)->where('deptcode', $code)->first();
        $this->authorize('update',$data);
        if ($data) {
            $this->editobject['deptcode'] =  $data->deptcode;
            $this->editobject['deptname'] =  $data->deptname;
            $this->editobject['address'] =  $data->address;
            $this->editobject['catcode'] =  $data->catcode;
        }
        $this->toggle('editmodal');
    }
    public function Update()
    {
        $this->authorize('update',DeptMaster::class);
        $this->editobject['distcode'] = $this->distcode;

        Validator::make(
            $this->editobject,
            [
                'distcode' => ['required'],
                'deptcode' => ['required'],
                'deptname' => ['required', 'string'],
                'address' => ['required', 'string'],
                'catcode' => ['required'],
            ],
            [
                'distcode.required' => 'Selection of District is mandatory.',
                'deptcode.required' => 'Department code is required.',
                'deptname.required' => 'Deparment Name is mandatory.',
                'address.required' => 'Address is mandatory.',
                'catcode.required' => 'Category is mandatory.',
            ]
        )->validate();
        $data = DeptMaster::where('distcode', $this->distcode)->where('deptcode', $this->editobject['deptcode'])->first();
        $subdept = SubDeptMaster::where('distcode', $this->distcode)->where('deptcode', $this->editobject['deptcode'])->where('subdeptcode','0001')->first();
       
        $this->authorize('update',$data);
        $data->deptname = $this->editobject['deptname'];
        $data->address = $this->editobject['address'];
        $data->catcode = $this->editobject['catcode'];
        $temp = DeptCateg::where('catcode', $this->editobject['catcode'])->get('centrestate')->first();
        $data->CentreState = $temp['centrestate'];
        $data->save();

        $subdept->subdept = $this->editobject['deptname'];
        $subdept->address = $this->editobject['address'];
        $subdept->save();

        $this->editobject['deptcode'] = '';
        $this->editobject['deptname'] = '';
        $this->editobject['address'] = '';
        $this->editobject['catcode'] = '';
        $this->editobject['CentreState'] = '';



        $this->toggle('editmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Department Details Updated successfully!'
        ]);

        $this->emit('close-banner');
    }
    public function openForDeletion($id)
    {
        $this->authorize('delete',DeptMaster::class);
        $id = $this->generateFourDigitCode($id);
        $data = DeptMaster::where('distcode', $this->distcode)->where('deptcode', $id)->first();
        $this->authorize('delete',$data);
        $this->editobject['deptcode'] = $data->deptcode;
        $this->editobject['deptname'] = $data->deptname;
        $this->editobject['address'] = $data->address;
        $this->editobject['catcode'] = $data->catcode;


        $this->toggle('confirmupdatemodal');
    }
    public function deleteRecord($code)
    {
        $this->authorize('delete',DeptMaster::class);
        $code = $this->generateFourDigitCode($code);
        // $subdept = SubDeptMaster::where('deptcode',$code)->first();
        // if($subdept)
        // {
        //     $this->toggle('confirmupdatemodal');
        //     $this->dispatchBrowserEvent('banner-message', [
        //     'style' => 'danger',
        //     'message' => 'Failed to delete the department. Delete all the subdepartments first!'
        //     ]);
        //     $this->emit('close-banner');

        //     return;
        // }

        $del = DeptMaster::where('distcode', $this->distcode)->where('deptcode', $code)->first();
        $this->authorize('delete',$del);
        try{

            $del->forceDelete();

           } catch (\Illuminate\Database\QueryException $e) {
            $message = ExceptionHelper::handleException($e);
            
            if($message = "FOREIGN_KEY_ERROR")
            {
                $message = "Failed to delete department. Delete all the subdepartments first!";
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

        $this->editobject['deptcodee'] = '';
        $this->editobject['deptname'] = '';
        $this->editobject['address'] = '';
        $this->editobject['catcode'] = '';

        $this->toggle('confirmupdatemodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'danger',
            'message' => 'Department Deleted Successfully!'
        ]);
        $this->emit('close-banner');
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
