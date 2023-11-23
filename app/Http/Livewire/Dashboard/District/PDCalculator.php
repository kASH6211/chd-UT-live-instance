<?php

namespace App\Http\Livewire\Dashboard\District;
use App\Models\Booth;
use App\Models\PollingData;
use Livewire\Component;
use Auth;
use DB;


class PDCalculator extends Component
{
    public $totbooths;
    public $distcode;
    public $newmodal=false;
    public $criteria = [
        "reserve"=>20,
        "centralemployee"=>0,
        "officeconsmale"=>0,
        "officeconsfemale"=>0,
        "residenceconsmale"=>0,
        "residenceconsfemale"=>0,
        "nativeconsmale"=>0,
        "nativeconsfemale"=>0,
        "femalepro"=>0,
        "nooffemales"=>0,
        "distribution"=>"Random"

    ];
    public $pollingparty = [
        "pro"=>1,
        "apro"=>1,
        "po"=>2,
        "reserve"=>20
    ];
   public $calculateddata=[
    "pro_req" =>0,
    "pro_avl" =>0,
    "pro_reserve" =>0,

    "apro_req" =>0,
    "apro_avl" =>0,
    "apro_reserve" =>0,

    "po_req" =>0,
    "po_avl" =>0,
    "po_reserve" =>0,
   ];
    public function mount()
    {
        $this->distcode = Auth::user()->distcode;
        $this->totbooths = Booth::where('DISTCODE',$this->distcode)->count();

    }
    public function render()
    {
        
        
       


       $this->calculateRequirements();
       $this->calculateAvailability();

      
       // dd($this->calculateddata);
        return view('livewire.dashboard.district.p-d-calculator');
    }
    public function getRequiredPO()
    {
        $countpo = 0;
        $booths = Booth::where('DISTCODE',$this->distcode)->get('NOOFOFFICER');
        foreach($booths as $booth)
        {
            $countpo = $countpo + ($booth['NOOFOFFICER'] -2); // Minus 2 because out of these NOOFOFFICER 1 is PRO and 1 is APRO
        }
        return $countpo;
    }
   
    public function calculateRequirements()
    {
        $reserve = ($this->criteria['reserve'])/100;
        $this->calculateddata['pro_req']=$this->totbooths; // Every booth will have at most 1 PRO
        $this->calculateddata['apro_req']=$this->totbooths; // Every booth will have at most 1 APRO
        $this->calculateddata['po_req'] = $this->getRequiredPO();
        $this->calculateddata['pro_reserve'] = ceil(($this->calculateddata['pro_req']  * $reserve)); 
        $this->calculateddata['apro_reserve'] = ceil(($this->calculateddata['apro_req']  * $reserve));
        $this->calculateddata['po_reserve'] =ceil(($this->calculateddata['po_req']  * $reserve));
    }
   public function calculateAvailability()
    {
        $reserve = (100+$this->pollingparty['reserve'])/100;
        $this->calculateddata['pro_avl']  = DB::table('polling_data')
            ->leftJoin('dept_masters', function ($join) {
                $join
                    ->on('polling_data.distcode', '=', 'dept_masters.distcode')
                    ->on('polling_data.deptcode', '=', 'dept_masters.deptcode');
                })->where('polling_data.class',1)->where('polling_data.del','o')->where('dept_masters.included','=','Y')->where('polling_data.distcode',$this->distcode)
                ->count();
                
        ;

        $this->calculateddata['apro_avl']  = DB::table('polling_data')
            ->leftJoin('dept_masters', function ($join) {
                $join
                    ->on('polling_data.distcode', '=', 'dept_masters.distcode')
                    ->on('polling_data.deptcode', '=', 'dept_masters.deptcode');
                })->where('polling_data.class',2)->where('polling_data.del','o')->where('dept_masters.included','=','Y')->where('polling_data.distcode',$this->distcode)
                ->count();
        ;

        $this->calculateddata['po_avl']  = DB::table('polling_data')
            ->leftJoin('dept_masters', function ($join) {
                $join
                    ->on('polling_data.distcode', '=', 'dept_masters.distcode')
                    ->on('polling_data.deptcode', '=', 'dept_masters.deptcode');
                })->where('polling_data.class',3)->where('polling_data.del','o')->where('dept_masters.included','=','Y')->where('polling_data.distcode',$this->distcode)
                ->count(); 
        ;
        
    //    $this->calculateddata['pro_avl'] = ceil(PollingData::where('distcode',$this->distcode)->where('class',1)->where('del','o')->count()); 
    //    dd( $this->calculateddata['pro_avl']);
    //    $this->calculateddata['apro_avl'] = ceil(PollingData::where('distcode',$this->distcode)->where('class',2)->where('del','o')->count()); 
    //     $this->calculateddata['po_avl'] = ceil(PollingData::where('distcode',$this->distcode)->where('class',3)->where('del','o')->count()); 
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
