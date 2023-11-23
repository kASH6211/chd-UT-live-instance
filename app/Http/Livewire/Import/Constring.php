<?php

namespace App\Http\Livewire\Import;

use App\Models\ConnectionMaster;
use App\Models\DistMaster;
use App\Models\DeptMaster;
use App\Models\SubDeptMaster;

use App\Models\DeptCateg;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class Constring extends Component
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
    public $addobject;
    public $editobject;
    public $distcode ;

    public function mount()
    {
        $this->distcode=Auth::user()->distcode ;
        $object = new ConnectionMaster();
        $editobject = new ConnectionMaster();
    }

    public function editobject()
    {
        
        $data = ConnectionMaster::where('distcode', $this->distcode)->first();
        // $this->authorize('update',$data);
        if ($data) {
            $this->editobject['distcode'] =  $data->distcode;
            $this->editobject['host'] =  $data->host;
            $this->editobject['database'] =  $data->database;
            $this->editobject['username'] =  $data->username;
            $this->editobject['password'] =  $data->password;
        }
       
        $this->toggle('editmodal');
    }

    public function Update(){
        $this->editobject['distcode'] =  $this->distcode;
        Validator::make(
            $this->editobject,
            [
                'distcode' => ['required'],
                'host' => ['required'],
                'database' => ['required', 'string'],
                'username' => ['required', 'string'],
                'password' => ['required'],
            ],
            [
                'distcode.required' => 'District is mandatory.',
                'host.required' => 'Host IP Address is required.',
                'database.required' => 'Database Name is mandatory.',
                'username.required' => 'Username is mandatory.',
                'password.required' => 'Password is mandatory.',
            ]
        )->validate();
        
        $data = ConnectionMaster::where('distcode', $this->distcode)->first();
        $data->host=$this->editobject['host'];
        $data->database=$this->editobject['database'];
        $data->username=$this->editobject['username'];
        $data->password=$this->editobject['password'];
        $data->save();        

        $this->editobject['distcode'] = '';
        $this->editobject['host'] = '';
        $this->editobject['database'] = '';
        $this->editobject['username'] = '';
        $this->editobject['password'] = '';



        $this->toggle('editmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Connection Details Updated successfully!'
        ]);

        $this->emit('close-banner');
    }

    public function add(){
        $this->addobject['distcode'] =  $this->distcode;
        Validator::make(
            $this->addobject,
            [
                'distcode' => ['required'],
                'host' => ['required'],
                'database' => ['required', 'string'],
                'username' => ['required', 'string'],
                'password' => ['required'],
            ],
            [
                'distcode.required' => 'District is mandatory.',
                'host.required' => 'Host IP Address is required.',
                'database.required' => 'Database Name is mandatory.',
                'username.required' => 'Username is mandatory.',
                'password.required' => 'Password is mandatory.',
            ]
        )->validate();

        
        $data = new ConnectionMaster();
        $data->distcode=$this->addobject['distcode'];
        $data->host=$this->addobject['host'];
        $data->database=$this->addobject['database'];
        $data->username=$this->addobject['username'];
        $data->password=$this->addobject['password'];
        $data->save(); 

        $this->addobject['distcode'] = '';
        $this->addobject['host'] = '';
        $this->addobject['database'] = '';
        $this->addobject['username'] = '';
        $this->addobject['password'] = '';



        $this->toggle('newmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Connection Details Added successfully!'
        ]);

        $this->emit('close-banner');
        return redirect('/import/pulldata');
    }

    public function render()
    {
        //  $this->authorize('view',ConnectionMaster::class);
        $header = ['District', 'Host IP', 'Database Name', 'Username','Password','Edit'];
        $data = ConnectionMaster::where('distcode', $this->distcode)->when($this->search, function ($query, $search) {
            return $query->where('deptname', 'ILIKE', "%$this->search%");
        })->orderBy('id', 'DESC')->paginate($this->perPage);
        $data->withPath('/import/connection');
       
        return view('livewire.import.constring', ["data" => $data, "header" => $header]);
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
          
        }
    }
}
