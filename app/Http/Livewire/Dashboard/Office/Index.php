<?php

namespace App\Http\Livewire\Dashboard\Office;

use Livewire\Component;
use App\Models\DeptMaster;
use App\Models\OfficeMaster;
use App\Models\PollingData;
use App\Models\DistMaster;
use App\Models\OfficeLock;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    public $perPage = 10;
    public $distcode;
    public $deptcode;
    public $officecode;
    public $districtname="";
    public $deptname="";
    public $officename="";
    public $totmale=0;
    public $totfemale=0;
    public $totexempted=0;
    public $totpd=0;
    public $totavailable=0;
    public $finalSubmit = false;
    public $modalfinalsubmit = false;

    public $totalhrmsdata = 0;
    public $hrmscompleted = 0;
    public $completedPercentage = 0;

   public $cansubmitdata = false;
    

    public function mount()
    {
        $this->distcode = Auth::user()->distcode;
        $this->deptcode = Auth::user()->deptcode;
        $this->officecode = Auth::user()->officecode;
        if($this->distcode)
        {
           $this->districtname = DistMaster::where('DistCode',$this->distcode)->first()->DistName;
        }
        if($this->distcode && $this->deptcode)
        {
            $this->deptname = DeptMaster::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->first()->deptname;

        }
        
        if($this->distcode && $this->deptcode && $this->officecode)
        {
            $this->totalhrmsdata = PollingData::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('officecode',$this->officecode)->where('hrmsdata',1)->count();
            $this->hrmscompleted = PollingData::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('officecode',$this->officecode)->where('hrmsdata',1)->where('completed',1)->count();
            $this->officename = OfficeMaster::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('officecode',$this->officecode)->first()->office;
            $this->totpd = PollingData::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('officecode',$this->officecode)->count();
            $this->totfemale = PollingData::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('officecode',$this->officecode)->where('sex','F')->count();
            $this->totmale = PollingData::where('distcode',$this->distcode)->where('deptcode',$this->deptcode)->where('officecode',$this->officecode)->where('sex','M')->count();
            $this->totexempted = PollingData::where('distcode', $this->distcode)
            ->where('deptcode', $this->deptcode)
            ->where('officecode', $this->officecode)
            ->where(function ($query) {
                $query->where('del', 'd')
                      ->orWhere('handicap', 1)
                      ->orWhere('longLeave', 1);
            })
            ->count();
            $this->totavailable = PollingData::where('distcode', $this->distcode)
            ->where('deptcode', $this->deptcode)
            ->where('officecode', $this->officecode)
            ->where('del', 'o')->where('completed',1)->count();

       
        }

        

    }

    public function render()
    {
        $exempted= null;
        $header = ['Name', 'Father/Husband Name','Sex','DOB','Designation','Reason For Exemption','Action'];
        $hrmsheader = ['Name', 'Father/Husband Name','Sex','DOB','Designation','Mobile','HRMS Code','Action'];

        if($this->distcode && $this->deptcode && $this->officecode)
        {
                $exempted=PollingData::where('distcode', $this->distcode)
                ->where('deptcode', $this->deptcode)
                ->where('officecode', $this->officecode)
                ->where(function ($query) {
                    $query->where('del', 'd')
                          ->orWhere('handicap', 1)
                          ->orWhere('longLeave', 1);
                })->orderBy('id','DESC')->paginate($this->perPage);

                $hrmsNCdata=PollingData::where('distcode', $this->distcode)
                ->where('deptcode', $this->deptcode)
                ->where('officecode', $this->officecode)
                ->where('hrmsdata',1)->where('completed',0)->where(function ($query) {
                    $query->where('transferred', '<>', 'T')
                        ->orWhereNull('transferred');
                })->orderBy('Name','ASC')->paginate($this->perPage);

                $hrmsTransferreddata=PollingData::where('distcode', $this->distcode)
                ->where('deptcode', $this->deptcode)
                ->where('officecode', $this->officecode)
                ->where('hrmsdata',1)->where('completed',0)->where('transferred','T')->orderBy('id','DESC')->get();

        }
        if($this->totpd>0 && count($hrmsNCdata)<=0)
        {
            $this->cansubmitdata = true;
        }
        $this->finalSubmit = $this->checkFinalSubmit();
        return view('livewire.dashboard.office.index',['exempted'=>$exempted,"hrmsNCdata"=>$hrmsNCdata, "hrmsTransferreddata"=>$hrmsTransferreddata,'hrmsheader'=>$hrmsheader,'header'=>$header]);
    }
    public function checkFinalSubmit()
    {
        $distcode = Auth::user()->distcode;
        $deptcode = Auth::user()->deptcode;
        $officecode = Auth::user()->officecode;
        $office = OfficeMaster::where('distcode',$distcode)->where('deptcode',$deptcode)->where('officecode',$officecode)->first();
        $locked = $office->hasLock;
        if($locked)
        {
        return true;
        }
        return false;


    }
     public function toggle($key)
    {
        switch($key)
        {
            case "modalfinalsubmit":
                $this->modalfinalsubmit = !$this->modalfinalsubmit;
                break;
            
        }
    }
    public function finalSubmit()
    {   
      $distcode = Auth::user()->distcode;
      $deptcode = Auth::user()->deptcode;
      $officecode = Auth::user()->officecode;
        $officeid = OfficeMaster::where('distcode',$distcode)->where('deptcode',$deptcode)->where('officecode',$officecode)->first()->id;
        OfficeLock::create([
            'office_id'=>$officeid,
            'distcode'=>$distcode,
            'employeesfinalized'=>$this->totpd,
            'finalized'=>0
        ]);
        $this->toggle('modalfinalsubmit');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Final submission of data successfully processed!'
        ]);
      
        $this->emit('close-banner');


    }
}
