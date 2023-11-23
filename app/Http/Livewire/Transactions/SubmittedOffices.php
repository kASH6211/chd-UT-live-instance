<?php

namespace App\Http\Livewire\Transactions;

use Livewire\Component;

use App\Models\OfficeMaster;
use App\Models\PollingData;
use App\Models\OfficeLock;
use App\Models\DeptMaster;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubmittedOffices extends Component
{
    use WithPagination;
    
    public $newmodal = false;
    public $count;
    public $data;
    public $total;
    public $submitted;
    public $finalized;
    public $inprogress;
    public $pending;
    public $pendinghrms;
    public $exported;
    public $title;
    public $distcode;
    protected $paginatedData;
    public $search = "";

    public function mount()
    {
       $this->distcode = Auth::user()->distcode;
        $this->total=OfficeMaster::where('distcode',Auth::User()->distcode)->count();
        $this->submitted=OfficeMaster::where('distcode',Auth::User()->distcode)->whereIn('id', OfficeLock::get('office_id'))->get()->count();
//         $this->pending=OfficeMaster::where('distcode',Auth::User()->distcode)->whereNotIn(['deptcode', 'distcode'], function ($query) {
//     $query->select(['deptcode', 'distcode'])
//         ->from('polling_data');})
// ->get()->count();
$this->pending = DB::table('office_masters')
            ->leftJoin('polling_data', function ($join) {
                $join->on('office_masters.distcode', '=', 'polling_data.distcode')
                    ->on('office_masters.deptcode', '=', 'polling_data.deptcode')
                    ->on('office_masters.officecode', '=', 'polling_data.officecode');
                })->where('office_masters.distcode',$this->distcode)
                ->whereNull('polling_data.deptcode') // Check if the combination doesn't match
        ->count();
       
        $this->pendinghrms = PollingData::where('distcode', $this->distcode)
    ->where('hrmsdata', 1)
    ->groupBy('distcode', 'deptcode', 'officecode')
    ->select('distcode', 'deptcode', 'officecode', DB::raw('SUM(completed) as total_completed'))
    ->havingRaw('SUM(completed) = 0')
    ->get()->count();
       
       
        // $this->pendinghrms = OfficeMaster::where('hrmsdata',1)->whereDoesntHave('pollingData', function ($query) {
        //     $query->where('polling_data.completed', 1);
        // })->get()->count();
        $this->pending=$this->pending+$this->pendinghrms;
    //dd($numberOfRows);
    //  $this->inprogress=OfficeMaster::->where('distcode',Auth::User()->distcode)->whereIn(['deptcode','officecode'],PollingData::where('distcode',Auth::User()->distcode)->select( 'deptcode','officecode')
    // ->distinct()
    // ->get())->whereIn('id', OfficeLock::get('office_id'))->count();
$offs = PollingData::selectRaw("CONCAT(CASE WHEN distcode < 10 THEN '0' ELSE '' END, distcode, deptcode, officecode) as officecodekey")
    ->where('distcode', $this->distcode)->where('completed',1)
    ->distinct()
    ->get();
    // $this->inprogress=OfficeMaster::whereIn(['officecode','deptcode'],$s)->get()->count();
   
     $this->inprogress = OfficeMaster::where('distcode',$this->distcode)->whereIn('officecodekey',$offs)->whereNotIn('id',OfficeLock::get('office_id'))->get()->count();

    }
    public function updatedSearch()
    {
        $this->gotoPage(1); // Go back to the first page when search query changes
    }
    public function render()
    {
        $this->paginatedData=OfficeMaster::leftJoin('office_locks', 'office_locks.office_id', '=', 'office_masters.id')
    ->where('office_masters.distcode',Auth::User()->distcode)->select('office_masters.*', 'office_locks.*') // Select the columns you need
    ->when($this->search, function ($query, $search) {
        return $query->where('office_masters.office', 'ILIKE', "%$this->search%");
    })
    ->orderBy('office_locks.finalized','ASC')->orderBy('office_locks.office_id','ASC')->paginate(50);

    $data = OfficeMaster::leftJoin('office_locks', 'office_locks.office_id', '=', 'office_masters.id')
    ->where('office_masters.distcode',Auth::User()->distcode)->select('office_masters.*', 'office_locks.*') // Select the columns you need
    ->get();
    $this->count=0;
    foreach($data as $ds)
    {
        $this->count=$this->count+($ds->employeesfinalized);
    }
        return view('livewire.transactions.submitted-offices',["datasubmitted"=>$this->paginatedData]);
    }
    public function showData($key)
    {
        
        switch($key)
        {
            case "total":
                $data = array();
                $this->title = "Total Offices added in your district";
                break;
            case "submitted":
                $data = array();
                $this->title = "Offices who have submitted employees data";

                break;
            case "progress":
                    $data = array();
                $this->title = "Offices where data entry is in progress";

                    break;
            case "pending":
                    $data = array();
                $this->title = "Offices where data entry is not yet initiated";

                    break;
            case "exported":
                $data = array();
                $this->title = "Offices where data entry is finalized and data is exported to DISE";

                    break;
            case "finalized":
                $data = array();
                $this->title = "Offices where data entry is finalized by DEO";
        }
       
        $this->toggle('newmodal');
    }
    public function getDeptName($deptcode)
    {
        if($deptcode)
            $dept= DeptMaster::where('distcode',$this->distcode)->where('deptcode',$deptcode)->first();

        if($dept)
            return $dept->deptname;
        return null;
    }
    public function toggle($key)
    {
        switch($key)
        {
            case "newmodal":
                $this->newmodal = !$this->newmodal;
                break;
        }
    } 
}
