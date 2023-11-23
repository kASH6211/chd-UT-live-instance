<?php

namespace App\Http\Livewire\Masters;

use Illuminate\Validation\Rule;

use Livewire\Component;
use App\Models\PayScale;
use App\Models\DistMaster;
use App\Models\ClassMaster;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Payscalemaster extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    public $search = "";
    public $distlist;
    public $perPage = 10;
    public $newmodal = false;
    public $editmodal = false;
    public $confirmupdatemodal = false;
    public $classlist;
    public $object;
    public $editobject;
    public $distcode ;

    public function mount()
    {
        $object = new PayScale();
        $editobject = new PayScale();
        $this->distcode=Auth::user()->distcode ;
        $this->distlist = DistMaster::all();
        $this->classlist = ClassMaster::all();
    }
    public function render()
    {
        $this->authorize('view',PayScale::class);
        $header = ['District', 'Pay Scale', 'Class of Employee', 'Edit', 'Delete'];
        $data = PayScale::where('distcode', $this->distcode)->when($this->search, function ($query, $search) {
            return $query->where('PayScale', 'ILIKE', "%$this->search%");
        })->orderBy('PayScaleCode', 'DESC')->paginate($this->perPage);
        $data->withPath('/master/payscale');
        $tot = PayScale::where('distcode',$this->distcode)->count();
        return view('livewire.masters.payscalemaster', ["data" => $data, "header" => $header, "total" => $tot, "classlist" => $this->classlist]);
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
    public function addobject()
    {
        
        $this->object['distcode'] = $this->distcode;
        $this->object['PayScaleCode'] = $this->generateCode($this->object['distcode']);

        Validator::make(
            $this->object,
            [
            
                'distcode' => ['required'],
                'PayScale' => ['required', 'string'],
                'class' => ['required'],


            ],
            [
                'distcode.required' => 'Selection of District is mandatory.',
                'PayScale.required' => 'Please provide a valid pay scale.',
                'class.required' => 'Selection of polling duty class is mandatory.',
                // 'PayScaleCode.unique' => 'PayScaleCode.',



                // Add more custom messages for other rules as needed.
            ]
        )->validate();



        $this->authorize('create',new PayScale($this->object));
        PayScale::create($this->object);
        $this->object['PayScale'] = '';
        $this->object['class'] = '';

        $this->toggle('newmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'New Pay Scale Added successfully!'
        ]);

        $this->emit('close-banner');
    }

    public function generateCode($district)
    {
        $pscode = PayScale::where('distcode', $district)->orderBy('PayScaleCode', 'ASC')->get('PayScaleCode')->last();

        if ($pscode) {
            $newpscode = intval($pscode['PayScaleCode']) + 1;

            return $newpscode;
        }
        return 1;
    }

    public function editobject($code)
    {
        $data = PayScale::where('distcode', $this->distcode)->where('PayScaleCode', $code)->first();
        $this->authorize('update',$data);
        if ($data) {
            $this->editobject['PayScale'] =  $data->PayScale;
            $this->editobject['class'] =  $data->class;
            $this->editobject['PayScaleCode'] =  $data->PayScaleCode;
        }
        $this->toggle('editmodal');
    }
    public function Update()
    {
        $this->editobject['distcode'] = $this->distcode;
        Validator::make(
            $this->editobject,
            [
                'distcode' => ['required'],
                'PayScaleCode' => ['required'],
                'PayScale' => ['required', 'string'],
                'class' => ['required'],

            ],
            [
                'distcode.required' => 'Selection of District is mandatory.',
                'PayScaleCode.required' => 'Pay Scale Code is mandatory.',
                'class.required' => 'Select polling duty class.',
                'PayScale.required' => 'Pay scale value is mandatory.',

                // Add more custom messages for other rules as needed.
            ]
        )->validate();
        $data = PayScale::where('distcode', $this->distcode)->where('PayScaleCode', $this->editobject['PayScaleCode'])->first();
        
        $data->PayScale = $this->editobject['PayScale'];
        $data->class = $this->editobject['class'];
        $this->authorize('update',$data);

        $data->save();
        $this->editobject['PayScaleCode'] = '';
        $this->editobject['class'] = '';
        $this->editobject['PayScale'] = '';

        $this->toggle('editmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Pay Scale Details Updated successfully!'
        ]);

        $this->emit('close-banner');
    }

    public function openForDeletion($id)
    {

        $data = PayScale::where('distcode', $this->distcode)->where('PayScaleCode', $id)->first();
        $this->authorize('delete',$data);
        $this->editobject['PayScaleCode'] = $data->PayScaleCode;
        $this->editobject['PayScale'] = $data->PayScale;
        $this->toggle('confirmupdatemodal');
    }
    public function deleteRecord($code)
    {
        $del = PayScale::where('distcode', $this->distcode)->where('PayScaleCode', $code)->first();
        $this->authorize('delete',$del);
        $del->delete();
        $this->editobject['PayScaleCode'] = '';
        $this->editobject['PayScale'] = '';

        $this->toggle('confirmupdatemodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'danger',
            'message' => 'Pay Scale Deleted Successfully!'
        ]);
        $this->emit('close-banner');
    }
}
