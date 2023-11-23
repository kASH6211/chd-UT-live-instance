<?php

namespace App\Http\Livewire\Transactions;
use App\Models\DesignationMaster;
use App\Models\DistMaster;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ClassMaster;
use App\Models\PollingData;
use App\Models\DeptMaster;
use App\Models\OfficeMaster;
use App\Models\PayScale;
use Illuminate\Support\Facades\Validator;
use App\Models\PollingDataPhoto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\ProAproBlo_MobileNoMaster;


class PollingPersonnelData extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    public $search="";
    public $distlist;
    public $perPage = 10;
    public $newmodal = false;
    public $distcode ;
 
    public $deptcode ;
    public $officecode;
    public $deptname;
    public $officename;
    public $delobject;
    public $viewobject;
    
    public $confirmdeletemodal=false;
    public $viewmodal=false;

    public function mount()
    {
               
        $this->distcode=Auth::user()->distcode;
 
        $this->deptcode=Auth::user()->deptcode;
        $this->officecode=Auth::user()->officecode;
        $this->distlist = DistMaster::all();

        $dept=DeptMaster::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->first();
        //dd($dept);
        $this->deptname=$dept->deptname;
        $office=OfficeMaster::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('officecode',$this->officecode)->first();
        $this->officename=$office->office.$office->address;
       
    }
    public function updatedSearch()
    {
        $this->resetPage();
    } 
    public function render()
    {

        $this->authorize('view',PollingData::class);
        $header = ['Photo', 'Name', 'Father/Husband Name','Sex','Address','Mobile', 'View Details'];
        
        $tot = PollingData::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('officecode',$this->officecode)->where('completed',1)->count();
      
        $data = PollingData::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('officecode',$this->officecode)->where('completed',1)->when($this->search,function($query, $search){
                return $query->where('Name','ILIKE',"%$this->search%");
         })->orderBy('updated_at','DESC')->paginate($this->perPage);
          $data->withPath('/transactions/employee');
        
      
        return view('livewire.transactions.polling-personnel-data',["header"=>$header,"data"=>$data,"total"=>$tot]);
    }
    
    public function toggle($key)
    {
        switch($key)
        {
            // case "newmodal":
            //     $this->newmodal = !$this->newmodal;
            //     break;
                case "viewmodal":
                $this->viewmodal = !$this->viewmodal;
                break;
                case "confirmdeletemodal":
                $this->confirmdeletemodal = !$this->confirmdeletemodal;
                break;
        }
    } 

    public function openForDeletion($id)
    {
        $this->toggle('viewmodal');
        
        $this->delobject=PollingData::find($id);
        $this->authorize('delete',$this->delobject);
        $this->toggle('confirmdeletemodal');
    }
    public function openForEditing($id)
    {
        return redirect('/transactions/employee/edit/'.$id);
    }
    public function deleteRecord($code)
    {
        $del = PollingData::find($code);
        $this->authorize('delete',$del);
        $delphoto=PollingDataPhoto::where('id',$del->photoid)->first();
        $delbloentry=ProAproBlo_MobileNoMaster::find($del->photoid);
        $delphoto->delete();
        if($delbloentry)
        $delbloentry->delete();
        

         $del->forceDelete();
         $this->delobject=null;
         

        $this->toggle('confirmdeletemodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'danger',
            'message' => 'An employee Removed Successfully!'
        ]);
        $this->emit('close-banner');
    }


    public function viewrecord($id)
    {

        $this->viewobject=PollingData::find($id);
        //dd($this->viewobject);
        $this->authorize('view',$this->viewobject);
        $this->toggle('viewmodal');

    }
    
    public function getPayScaleTitle()
    {
        $title = PayScale::find(['PayScaleCode' => $this->viewobject->PayScaleCode, 'distcode' => $this->viewobject->distcode])->first()->PayScale;
        return $title;
    }
    


    public function retrieveImage($imageid)
    {
        
      if($imageid)
      {
        $pdp =  PollingDataPhoto::where('id',$imageid)->first();
        if($pdp)
        {
            //dd(pg_escape_bytea(stream_get_contents($pdp->empphoto)));
            return 'data:image/jpeg;base64,'.stream_get_contents($pdp->empphoto);
        }
      }
        return "Photo";

    }
    
}
