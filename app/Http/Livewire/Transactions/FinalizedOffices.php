<?php

namespace App\Http\Livewire\Transactions;

use Livewire\Component;
use App\Models\OfficeMaster;
use App\Models\PollingData;
use App\Models\DeptMaster;
use App\Models\OfficeLock;
use Illuminate\Support\Facades\Auth;

class FinalizedOffices extends Component
{
    public $newmodal = false;
    public $distcode;
    public $data;
    public $count;
    public $total;
    public $submitted;
    public $finalized;
    public $inprogress;
    public $pending;
    public $exported;
    public $title;
    public $search = "";
    protected $paginatedData;


    public function mount()
    {
        $this->distcode=Auth::User()->distcode;
        $this->total=OfficeMaster::where('distcode',$this->distcode)->count();
        $this->submitted=OfficeMaster::where('distcode',$this->distcode)->whereIn('id', OfficeLock::where('finalized',0)->get('office_id'))->get()->count();
        $this->finalized=OfficeMaster::where('distcode',$this->distcode)->whereIn('id', OfficeLock::where('finalized',1)->get('office_id'))->get()->count();

    }
    public function getDeptName($deptcode)
    {
        if($deptcode)
            $dept= DeptMaster::where('distcode',$this->distcode)->where('deptcode',$deptcode)->first();
        if($dept)
            return $dept->deptname;
        return null;
    }
    public function openDetails($recordid)
    {
        $id = intval($recordid);
       $url = 'transactions/submitted/'.$id;
     //  dd($url);
        return $this->redirect($url);
    }
    public function updatedSearch()
    {
        $this->gotoPage(1); // Go back to the first page when search query changes
    }

    public function render()
    {
        $this->paginatedData=OfficeMaster::leftJoin('office_locks', 'office_locks.office_id', '=', 'office_masters.id')
    ->where('office_masters.distcode',$this->distcode)->select('office_masters.*', 'office_locks.*') // Select the columns you need
    ->when($this->search, function ($query, $search) {
        return $query->where('office_masters.office', 'ILIKE', "%$this->search%");
    })
    ->paginate(50);

    $datas=OfficeMaster::leftJoin('office_locks', 'office_locks.office_id', '=', 'office_masters.id')
    ->where('office_masters.distcode',$this->distcode)->select('office_masters.*', 'office_locks.*') // Select the columns you need
    ->get();
    $this->count=0;
    foreach($datas as $ds)
    {
        if($ds->finalized ==1)
        $this->count=$this->count+($ds->employeesfinalized);
    }
        return view('livewire.transactions.finalized-offices',["datasubmitted"=>$this->paginatedData]);
    }
   
}
