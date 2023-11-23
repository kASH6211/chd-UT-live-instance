<?php

namespace App\Http\Livewire\Dashboard\District;
use DB;
use Livewire\Component;
use App\Models\OfficeMaster;
use App\Models\PollingData;
use App\Models\OfficeLock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class OfficeSummary extends Component
{
    use AuthorizesRequests;
    public $newmodal = false;
    public $distcode;
    public $data;
    public $total;
    public $submitted;
    public $inprogress;
    public $pending;
    public $pendinghrms;
    public $imported;
    public $finalized;
    public $title;
    
    public function mount()
    {
        $this->distcode = Auth::User()->distcode;
        $this->total=OfficeMaster::where('distcode',$this->distcode)->count();
        $this->submitted=OfficeMaster::where('distcode',$this->distcode)->whereIn('id', OfficeLock::get('office_id'))->get()->count();
        $this->finalized=OfficeMaster::where('distcode',$this->distcode)->whereIn('id', OfficeLock::where('finalized',1)->get('office_id'))->get()->count();
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
        
        $offs = PollingData::selectRaw("CONCAT(CASE WHEN distcode < 10 THEN '0' ELSE '' END, distcode, deptcode, officecode) as officecodekey")
        ->where('distcode', $this->distcode)->where('completed',1)
        ->distinct()
        ->get();
        
        $this->inprogress=OfficeMaster::where('distcode',$this->distcode)->whereIn('officecodekey',$offs)->whereNotIn('id',OfficeLock::get('office_id'))->get()->count();
       
        // $this->inprogress=PollingData::where('distcode', $this->distcode)
        // ->where('hrmsdata', 0)
        // ->groupBy('distcode', 'deptcode', 'officecode')
        // ->select('distcode', 'deptcode', 'officecode', DB::raw('SUM(completed) as total_completed'))
        // ->get()->count();

        // $this->inprogresshrms = PollingData::where('distcode', $this->distcode)
        // ->where('hrmsdata', 1)
        // ->groupBy('distcode', 'deptcode', 'officecode')
        // ->select('distcode', 'deptcode', 'officecode', DB::raw('SUM(completed) as total_completed'))
        // ->havingRaw('SUM(completed) <> 0')
        // ->get()->count();

        // $this->inprogress=$this->inprogress+$this->inprogresshrms;
       
        $this->imported=OfficeMaster::where('distcode',$this->distcode)->whereIn('id', OfficeLock::where('imported',1)->get('office_id'))->get()->count();
    
    }
    
    public function render()
    {
        
       
       
        return view('livewire.dashboard.district.office-summary');
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
