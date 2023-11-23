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

class Exemption extends Component
{
    use WithPagination;
    public $distcode;
    public $deptcode;
    public $officecode;
    public $alldeptlist;
    public $allofficelist;
    public $filterofficelist;
    public $search;
    public $searchresult = [];
    public $exemptmodal;
    public $empid;
    public $Remarks;

    public $perPage = 25;

    public function mount()
    {

        $this->distcode = Auth::user()->distcode;
        $this->alldeptlist = DeptMaster::where('distcode', $this->distcode)->get();
        $this->allofficelist = OfficeMaster::where('distcode', $this->distcode)->get();

        // $this->filterofficelist=$this->allofficelist;  
    }
    public function deptchange()
    {
        if ($this->deptcode != "") {
            $this->filterofficelist = OfficeMaster::where('distcode', $this->distcode)
                ->where('deptcode', $this->deptcode)->get();
        } else {
            $this->deptcode = null;
            $this->officecode = null;
            $this->filterofficelist = null;
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
    public function exemptobject()
    {
        $data = ["Remarks" => $this->Remarks];
        Validator::make(
            $data,
            [
                'Remarks' => ['required', 'string']
            ],
            [
                'Remarks.required' => 'Remarks for Exemption is mandatory.',
                // Add more custom messages for other rules as needed.
            ]
        )->validate();

        if ($this->empid) {
            $this->empid->Remarks = $this->empid->Remarks . "-->" . $this->Remarks;
            $this->empid->del = 'd';
            $this->empid->save();
            $this->toggle();
        }
    }

    public function getdata($id)
    {
        $this->empid = PollingData::find($id);
        $this->toggle();
    }
    public function toggle()
    {
        $this->exemptmodal = !$this->exemptmodal;
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
        $deptlist = OfficeLock::where('distcode', $this->distcode)->where('imported', 0)->pluck('office_id');
        $off = OfficeMaster::whereIn('id', $deptlist)->get();
        if (count($off)) {
            $conditions = [];
            foreach ($off as $o) {
                $conditions[] = ['distcode' => $o->distcode, 'deptcode' => $o->deptcode, 'officecode' => $o->officecode];
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

        


        return view('livewire.transactions.exemption', [
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
