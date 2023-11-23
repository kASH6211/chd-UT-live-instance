<?php

namespace App\Http\Livewire\Masters;


use App\Helpers\ExceptionHelper;
//use App\Models\PayScale;

use App\Models\ConsDist;
use App\Models\ConsList;
use App\Models\DistMaster;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class Consdistmaster extends Component
{

    use WithPagination;
    use AuthorizesRequests;
   
    public $search="";
    public $distlist;
    public $perPage = 10;
    public $newmodal = false;
    public $editmodal = false;
    public $confirmupdatemodal = false;
    //public $classlist;
    public $object =null ;
    public $editobject ;
    public $distcode ;
    public $aclist=[];
   

    public function mount()
    {
       $object=new ConsDist();
        $editobject=new ConsDist();
        $this->distcode=Auth::user()->distcode ;
        //$this->distlist = DistMaster::all();
        $temp=ConsList::all();
        foreach($temp as $item)
        {
            $acno = $item->AC_NO;
            if($acno<10)
            {   
                $acno = "0".$acno;
            }
            $item->AC_NAME = $item->AC_NAME." (".$acno.")";
            array_push($this->aclist,$item);
        }
       
       
            
    }


    public function render()
    {
        $this->authorize('view',ConsDist::class);
        $header=['District','Constituency','Edit','Delete'];
        
          if($this->distcode)
          {
$data =  ConsDist::where('distcode',$this->distcode)->when($this->search,function($query, $search){
                return $query->where('ac_name','ILIKE',"%$this->search%");
         })->orderBy('ac_no','ASC')->paginate($this->perPage);
          $data->withPath('/master/district/constituency');
                $tot =  ConsDist::where('distcode',$this->distcode)->get()->count();

             
          }
          else
          {
             $data = ConsDist::when($this->search,function($query, $search){
                return $query->where('ac_name','LIKE',"%$this->search%");
         })->orderBy('ac_no','DESC')->paginate($this->perPage);
          $data->withPath('/master/district/constituency');    
            $tot = ConsDist::all()->count();
          }
       
          return view('livewire.masters.consdistmaster',["data"=>$data,"header"=>$header,"total"=>$tot,"distlist"=>$this->distlist]);
    }
      

    public function addobject()
    {
        
        if($this->object && $this->object['ac_no'])
        {
            $conslist=ConsList::where('AC_NO',$this->object['ac_no'])->get()->first();
            $this->object['distcode']=$this->distcode;
            $this->object['ac_name']=$conslist->AC_NAME;
            Validator::make($this->object, [
               'ac_name' => ['required', 'string'],],['ac_name.required' => 'Selection of assembly constituency is mandatory.'])->validate();
            $this->authorize('create',new ConsDist($this->object));
            
           try{
            ConsDist::create($this->object);
           } catch (\Illuminate\Database\QueryException $e) {
            $message = ExceptionHelper::handleException($e);
            
            if($message = "DUPLICATE_KEY_ERROR")
            {
                $message = "This constituency is already added to your district!";
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
                    $this->toggle('newmodal');
                    return;
            } 
            $this->object['ac_name']='';
            $this->object['ac_no']=null;
            $this->toggle('newmodal');
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'success',
                'message' => 'New District Constituency Mapping Added successfully!'
            ]);
            $this->emit('close-banner');
        }
        else
        {
            Validator::make(["ac_no"=>null], [
                'ac_no' => ['required', 'string'],],['ac_no.required' => 'Selection of assembly constituency is mandatory.'])->validate();
        }
       
    }

    public function editobject($code)
    {
        $this->authorize('update',ConsDist::class);
       $data = ConsDist::where('distcode',$this->distcode)->where('ac_no',$code)->first();
       $this->authorize('update',$data);
       if($data)
       {
              $this->editobject['ac_name'] =  $data->ac_name;
              $this->editobject['ac_no'] =  $data->ac_no;
              $this->editobject['id'] =  $data->id;
              
                 
       }
       $this->toggle('editmodal');
    }


    public function Update()
    {
       // $this->authorize('update',ConsDist::class);
       if($this->editobject && $this->editobject['ac_no'])
       {
            $this->editobject['distcode'] =$this->distcode;
            Validator::make($this->editobject, [
                'ac_name'=> ['required'],
                'id'=> ['required'],
            ],
            [
                'ac_name.required' => 'Selection of Constituency is mandatory.',
            ])->validate();
           $data = ConsDist::where('id',$this->editobject['id'])->first();
           $this->authorize('update',$data);
           $conslist=ConsList::where('AC_NO',$this->editobject['ac_no'])->get()->first();
           $data->ac_name = $conslist->AC_NAME;
           $data->ac_no = $this->editobject['ac_no'];
           try{
            $data->save();


           } catch (\Illuminate\Database\QueryException $e) {
            $message = ExceptionHelper::handleException($e);
            
            if($message = "DUPLICATE_KEY_ERROR")
            {
                $message = "This constituency is already added to your district!";
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
                    $this->toggle('editmodal');
                    return;
            } 
           $this->editobject['id']='';
           $this->editobject['ac_no']='';
           $this->editobject['ac_name']='';
           $this->toggle('editmodal');
           $this->dispatchBrowserEvent('banner-message', [
               'style' => 'success',
               'message' => 'Constituency Updated successfully!'
           ]);
           $this->emit('close-banner');
        }
        else
        {
            Validator::make(["ac_no"=>null], [
                'ac_no' => ['required', 'string'],],['ac_no.required' => 'Selection of assembly constituency is mandatory.'])->validate();
        }

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

    public function openForDeletion($id)
    {
        //$this->authorize('delete',ConsDist::class);
        $data = ConsDist::where('distcode',$this->distcode)->where('ac_no',$id)->first();
        $this->authorize('delete',$data);
         $this->editobject['ac_no'] = $data->ac_no;
         $this->editobject['ac_name'] = $data->ac_name;
        $this->toggle('confirmupdatemodal');
    }
    public function deleteRecord($code)
    {
        $this->authorize('delete',ConsDist::class);
        $del = ConsDist::where('distcode',$this->distcode)->where('ac_no',$code)->first();
        $this->authorize('delete',$del);

        try{
            $del->delete();

           } catch (\Illuminate\Database\QueryException $e) {
            $message = ExceptionHelper::handleException($e);
            
            if($message = "FOREIGN_KEY_ERROR")
            {
                $message = "This constituency is referenced in some other table and cannot be deleted!";
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
        $this->editobject['ac_no'] = '';
        $this->editobject['ac_name'] = '';

        $this->toggle('confirmupdatemodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Constituency Removed Successfully!'
        ]);
        $this->emit('close-banner');
    }
   

    
}
