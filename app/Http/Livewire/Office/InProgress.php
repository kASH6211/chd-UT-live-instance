<?php

namespace App\Http\Livewire\Office;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\OfficeMaster;
use App\Models\DeptMaster;
use App\Models\SubdeptMaster;
use App\Models\OfficeLock;
use Livewire\WithPagination;
use App\Models\PollingData;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InProgress extends Component
{use WithPagination;
    use AuthorizesRequests;
    public $distcode;
    public $search="";
    public $perPage = 23;
    
    public function mount()
    {
        $this->distcode=Auth::user()->distcode ;
    }
    public function render()
    {
        $this->authorize('view',OfficeMaster::class);
        $depts=PollingData::where('distcode',$this->distcode)->distinct()->get('deptcode');
        //$offs=PollingData::where('distcode',$this->distcode)->distinct()->get('officecode');
        $offs = PollingData::selectRaw("CONCAT(CASE WHEN distcode < 10 THEN '0' ELSE '' END, distcode, deptcode, officecode) as officecodekey")
    ->where('distcode', $this->distcode)->where('completed',1)
    ->distinct()
    ->get();

        $header=['Office','Department','Sub-department', 'Office Address'];
        $data =  OfficeMaster::where('distcode',$this->distcode)->whereIn('officecodekey',$offs)->whereNotIn('id',OfficeLock::get('office_id'))->when($this->search,function($query, $search){
                return $query->where('office','ILIKE',"%$this->search%");
            })->orderBy('id','DESC')->paginate($this->perPage);
            $data->withPath('/office/detail');
            $tot = OfficeMaster::where('distcode',$this->distcode)->whereIn('officecodekey',$offs)->whereNotIn('id',OfficeLock::get('office_id'))->get()->count();
        return view('livewire.office.in-progress',["data"=>$data,"header"=>$header,"total"=>$tot]);
    }
    public function getSubDeptName($deptcode,$subdeptcode)
    {
        if($subdeptcode)
            $subdept= SubdeptMaster::where('distcode',$this->distcode)->where('deptcode',$deptcode)->where('subdeptcode',$subdeptcode)->first();
        if($subdept)
            return $subdept->subdept;
        return null;
    }

    public function getDeptName($deptcode)
    {
        if($deptcode)
            $dept= DeptMaster::where('distcode',$this->distcode)->where('deptcode',$deptcode)->first();
        if($dept)
            return $dept->deptname;
        return null;
    }
}
