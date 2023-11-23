<?php

namespace App\Http\Livewire\Dashboard\District;

use App\Http\Livewire\Masters\District;
use App\Models\DeptMaster;
use App\Models\DistMaster;
use App\Models\OfficeMaster;
use App\Models\PollingData;
use Livewire\Component;
use Livewire\WithPagination;

class Hrmsdistrictstats extends Component
{
    use WithPagination;
    public function render()
    {
        $headers=["District Name","Total Departments","Total Offices","Total Employee"];
        $districts= DistMaster::Paginate(30);
        $dep=[];
        $off=[];
        $emp=[];
        foreach($districts as $d){
            $dep[$d->id]=DeptMaster::where('distcode',$d->id)->count();
            $off[$d->id]=OfficeMaster::where('distcode',$d->id)->count();
            $emp[$d->id]=PollingData::where('distcode',$d->id)->count();
        }
        return view('livewire.dashboard.district.hrmsdistrictstats',["headers"=>$headers,
        "districts"=>$districts,"dept"=>$dep,"off"=>$off,"emp"=>$emp]);
    }
}
