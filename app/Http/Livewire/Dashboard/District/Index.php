<?php

namespace App\Http\Livewire\Dashboard\District;

use Livewire\Component;
use App\Models\DeptMaster;
use App\Models\SubdeptMaster;
use App\Models\OfficeMaster;
use App\Models\PollingData;
use App\Models\Booth;
use App\Models\BoothLocn;
use App\Models\ConsDist;
use App\Models\DistMaster;

use Auth;
use DB;
class Index extends Component
{
    public $totdept=0;
    public $totsubdept=0;
    public $totoffice=0;
    public $totpd=0;
    public $totlocations=0;
    public $totbooths=0;
    public $distcode;
    public $distname;
    public $pssummary;
    public $chartboothslabels=array();
    public $chartboothsdata=array();
   
    

    public function mount()
    {
        $this->distcode = Auth::user()->distcode;
        $this->distname = $this->getDistrictName($this->distcode);

      
        if($this->distcode)
        {
            $this->totdept = DeptMaster::where('distcode',$this->distcode)->count();
            $this->totsubdept = SubdeptMaster::where('distcode',$this->distcode)->count();
            $this->totoffice= OfficeMaster::where('distcode',$this->distcode)->count();
            $this->totpd = PollingData::where('distcode',$this->distcode)->count();
            $this->totlocations = BoothLocn::where('DISTCODE',$this->distcode)->count();
            $this->totbooths = Booth::where('DISTCODE',$this->distcode)->count();
        }
        $this->pssummary = $this->getPollingStationData();
        $abc=$this->getSensitiveBooths();
        
        
    }
    public function getDistrictName($distcode)
    {
        return $distname = DistMaster::where('DistCode',$distcode)->first()->DistName;
    }
  
    public function getPollingStationData()
    {
        $locations = BoothLocn::where('DISTCODE', $this->distcode)
            ->select('CONSCODE', DB::raw('count(*) as locationCount'))
            ->groupBy('CONSCODE')
            ->get();

        $booths = Booth::where('DISTCODE', $this->distcode)
            ->select('CONSCODE', DB::raw('count(*) as boothCount'))
            ->groupBy('CONSCODE')
            ->get();

        $mergedCollection = $locations->map(function ($location) use ($booths) {
            $matchingBooth = $booths->firstWhere('CONSCODE', $location['CONSCODE']);
            return [
                    'CONSCODE' => $location['CONSCODE'],
                    'Locations' => $location['locationcount'],
                    'Booths' => $matchingBooth ? $matchingBooth['boothcount'] : 0,
            ];
        });
        $sensitivebooths = $this->getSensitiveBooths();

        $mgc =  $mergedCollection->map(function ($mg) use ($sensitivebooths) {
            $matchingBooth = $sensitivebooths->firstWhere('CONSCODE', $mg['CONSCODE']);
            return [
                    'CONSCODE' => $mg['CONSCODE'],
                    'Locations' => $mg['Locations'],
                    'Booths' => $mg['Booths'],
                    'Sensitive' => $matchingBooth ? $matchingBooth['sensitive'] : 0,
            ];
        });

        $ordinarybooths = $this->getOrdinaryBooths();
        $mgco =  $mgc->map(function ($mg) use ($ordinarybooths ) {
            $matchingBooth = $ordinarybooths->firstWhere('CONSCODE', $mg['CONSCODE']);
            return [
                    'CONSCODE' => $mg['CONSCODE'],
                    'Locations' => $mg['Locations'],
                    'Booths' => $mg['Booths'],
                    'Sensitive' => $mg['Sensitive'],
                    'Ordinary' => $matchingBooth ? $matchingBooth['ordinary'] : 0,
            ];
        });
        $vsensitivebooths = $this->getVerySensitiveBooths();
        $mgcv =  $mgco->map(function ($mg) use ($vsensitivebooths ) {
            $matchingBooth = $vsensitivebooths->firstWhere('CONSCODE', $mg['CONSCODE']);
            return [
                    'CONSCODE' => $mg['CONSCODE'],
                    'Locations' => $mg['Locations'],
                    'Booths' => $mg['Booths'],
                    'Sensitive' => $mg['Sensitive'],
                    'Ordinary' => $mg['Ordinary'],
                    'VSensitive' => $matchingBooth ? $matchingBooth['vsensitive'] : 0,
            ];
        });
      
        foreach($booths as $bt)
        {
            $name = $this->getConsName($bt['CONSCODE']);

            array_push($this->chartboothslabels,$name);
            array_push($this->chartboothsdata,$bt['boothcount']);

        }
        //dd($labels);
       
 return $mgcv;
    
    }

    public function getOrdinaryBooths()
    {
        $booths = Booth::where('DISTCODE', $this->distcode)->where('TYPE','Ordinary')
        ->select('CONSCODE', DB::raw('count(*) as ordinary'))
        ->groupBy('CONSCODE')
        ->get();
        return $booths;

    }
    public function getSensitiveBooths()
    {
        $booths = Booth::where('DISTCODE', $this->distcode)->where('TYPE','Sensitive')
        ->select('CONSCODE', DB::raw('count(*) as sensitive'))
        ->groupBy('CONSCODE')
        ->get();
        return $booths;

    }
    public function getVerySensitiveBooths()
    {
        $booths = Booth::where('DISTCODE', $this->distcode)->where('TYPE','Very Sensitive')
        ->select('CONSCODE', DB::raw('count(*) as vsensitive'))
        ->groupBy('CONSCODE')
        ->get();
        return $booths;

    }

    public function getConsName($code)
    {
        $name = ConsDist::where('distcode',$this->distcode)->where('ac_no',$code)->first();
        if($name)
        {
            return $name['ac_name'];
        }
        return "ERROR";
    }

    public function render()
    {
//         $locations = BoothLocn::where('DISTCODE', $this->distcode)
//     ->select('CONSCODE', DB::raw('count(*) as locationCount'))
//     ->groupBy('CONSCODE')
//     ->get();
//      $booths = Booth::where('DISTCODE', $this->distcode)
//     ->select('CONSCODE', DB::raw('count(*) as boothCount'))
//     ->groupBy('CONSCODE')
//     ->get();
    
//     $mergedCollection = $locations->map(function ($location) use ($booths) {
//     $matchingBooth = $booths->firstWhere('CONSCODE', $location['CONSCODE']);
    
//     return [
//         'CONSCODE' => $location['CONSCODE'],
//         'Locations' => $location['locationcount'],
//         'Booths' => $matchingBooth ? $matchingBooth['boothcount'] : 0,
//     ];
// });
// dd($mergedCollection);


    
        return view('livewire.dashboard.district.index');
    }
}
