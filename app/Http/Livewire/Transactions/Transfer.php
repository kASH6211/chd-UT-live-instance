<?php

namespace App\Http\Livewire\Transactions;

use App\Models\DeptMaster;
use App\Models\OfficeLock;
use App\Models\OfficeMaster;
use App\Models\PollingData;
use App\Models\PollingDataPhoto;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Transfer extends Component
{
    use WithPagination;
    public $distcode;
    public $deptcode;
    public $officecode;
    public $alldeptlist;
    public $allofficelist;
    public $filterofficelist;
    public $newfilterofficelist;
    public $newdeptcode;
    public $newofficecode;
    public $search;
    public $searchresult = [];
    public $transfermodal;
    public $empid;
    public $Remarks;

    public $perPage = 25;

    public function mount()
    {

        $this->distcode = Auth::user()->distcode;
        $this->alldeptlist = DeptMaster::where('distcode', $this->distcode)->orderBy('deptname','ASC')->get();
        $this->allofficelist = OfficeMaster::where('distcode', $this->distcode)->orderBy('office','ASC')->get();

        // $this->filterofficelist=$this->allofficelist;  
    }
    public function deptchange()
    {
        if ($this->deptcode != "") {
            $this->filterofficelist = OfficeMaster::where('distcode', $this->distcode)
                ->where('deptcode', $this->deptcode)->orderBy('office','ASC')->get();
        } else {
            $this->deptcode = null;
            $this->officecode = null;
            $this->filterofficelist = null;
        }
    }

    public function newdeptchange()
    {
        if ($this->newdeptcode != "") {
            $this->newfilterofficelist = OfficeMaster::where('distcode', $this->distcode)
                ->where('deptcode', $this->newdeptcode)->orderBy('office','ASC')->get();
        } else {
            $this->newdeptcode = null;
            $this->newofficecode = null;
            $this->newfilterofficelist = null;
        }
    }

    public function officechange()
    {
        if ($this->officecode == "") {
            $this->officecode = null;
        }
    }
    public function removeexemptobject()
    {
        if ($this->empid) {
            $parts = explode('-->', $this->empid->Remarks);
            $firstPart = $parts[0];
            $this->empid->Remarks = $firstPart;
            $this->empid->del = 'o';
            $this->empid->save();
            $this->toggle();
        }
    }
    public function transferobject()
    {
        $data = ["newdeptcode" => $this->newdeptcode,"newofficecode" => $this->newofficecode];
        Validator::make(
            $data,
            [
                'newdeptcode' => ['required'],
                'newofficecode' => ['required']

            ],
            [
                'newdeptcode.required' => 'Select Department where Employee is Transferred to.',
                'newofficecode.required' => 'SelectOffice where Employee is Transferred to.',
                // Add more custom messages for other rules as needed.
            ]
        )->validate();

        if ($this->empid) {
            $newdeptslno=$this->fetchdeptslnofromID($this->distcode,$this->newdeptcode,$this->newofficecode);
            $newphotoid=$this->generatePhotoId($this->distcode,$this->newdeptcode,$this->newofficecode,$newdeptslno);
            dd($this->distcode,$this->newdeptcode,$this->newofficecode);
            $photoid=PollingDataPhoto::where('id',$this->empid->photoid)->first();
            $tempdata["id"]=$newphotoid;
            $tempdata["deptslno"]=$newdeptslno;
            $tempdata["empphoto"]=$photoid->empphoto;

            $photoid->delete();
            
            
            
            //update polling_data
            $this->empid->photoid=$newphotoid;
            $this->empid->deptcode = $this->newdeptcode ;
            $this->empid->officecode = $this->newofficecode ;
            $this->empid->del = 'o';
            $this->empid->transferred = 'N';
            $this->empid->save();
            
            PollingDataPhoto::create($tempdata);

            $this->toggle();
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'success',
                'message' => 'Employee Transfered to New Department-Office'
            ]); 
            $this->emit('close-banner');
        }
    }

    public function generatePhotoId($distcode,$deptcode,$officecode,$deptslno)
    {
        if($distcode<10)
            $distcode = '0'.$distcode;
        $deptcode = $this->addPadding($deptcode);
        $officecode = $this->addPadding($officecode);
        $deptslno = $this->addPadding($deptslno);
        $temp=$distcode.$deptcode.$officecode.$deptslno;
        return $temp;

    }
    public function addPadding($code)
    {
       $code = intval($code);
        if($code<10)
            return '000'.$code;
        else if($code>=10 && $code<100)
            return '00'.$code;
        else if($code>=100 && $code<1000)
            return '0'.$code;
        
            return $code;
    }


    public function fetchdeptslnofromID($distcode,$deptcode,$officecode)
    {
        $pdcount = PollingData::where('distcode',$distcode)->where('deptcode',$deptcode)->where('officecode',$officecode)->orderBy('id','DESC')->first();
        dd($pdcount);
        
        $temp=1;
        
        if($pdcount && $pdcount->deptslno!=null){
         $temp=($pdcount->deptslno+1);}
        
        return $temp;
    }

    public function getdata($id)
    {
        $this->empid = PollingData::find($id);
        $this->toggle();
    }
    public function toggle()
    {
        $this->transfermodal = !$this->transfermodal;
        $this->Remarks = "";
    }
    public function getOfficeName($distcode, $deptcode, $officecode)
    {
        $office = OfficeMaster::where('distcode', $distcode)->where('deptcode', $deptcode)->where('officecode', $officecode)->first();
        return $office->office;
    }
    public function render()
    {

        $header = ['Name', 'Father/Husband Name', 'Mobile', 'Office', 'Designation', 'Action'];
        $deptlist = DeptMaster::where('distcode', $this->distcode)->pluck('deptcode');
        $off = OfficeMaster::whereIn('deptcode', $deptlist)->get();
        if (count($off)) {
            $conditions = [];
            foreach ($off as $o) {
                $conditions[] = ['transferred'=>'T','del'=>'d','distcode' => $o->distcode, 'deptcode' => $o->deptcode, 'officecode' => $o->officecode];
            }

            $query = PollingData::where(function ($query) use ($conditions) {
                foreach ($conditions as $condition) {
                    $query->orWhere(function ($subQuery) use ($condition) {
                        foreach ($condition as $field => $value) {
                            $subQuery->where($field, $value);
                        }
                    });
                }
            });

            if ($this->deptcode) {
                $query->where('deptcode', $this->deptcode);
            }

            if ($this->officecode) {
                $query->where('officecode', $this->officecode);
            }

            if ($this->search) {
                $s = $this->search;
                $query->where(function ($subquery) use ($s) {
                    $subquery->where('Name', 'ILIKE', "%$this->search%")
                        ->orwhere('FName', 'ILIKE', "%$this->search%")
                        ->orwhere('hrmscode', 'ILIKE', "%$this->search%")
                        ->orwhere('mobileno', 'ILIKE', "%$this->search%");
                });
            }
            $result = $query->orderBy('id', 'DESC')->paginate($this->perPage);
        }
        else{
            $result=null;
        }

        


        return view('livewire.transactions.transfer', [
            'header' => $header,
            "result" => $result
        ]);
    }
    public function retrieveImage($imageid)
    {

        if ($imageid) {
            $pdp =  PollingDataPhoto::where('id', $imageid)->first();
            if ($pdp) {

                return 'data:image/jpeg;base64,'.stream_get_contents($pdp->empphoto);
            }
        }
        return "Photo";
    }
}
