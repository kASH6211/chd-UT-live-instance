<?php

namespace App\Http\Livewire\Reports;

use App\Models\PollingData;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Undertaking extends Component
{
    public $tot;
    public $emptype=[];
    public $distcode;
    public $deptcode;
    public $officecode;
    public function render()
    {
        $this->distcode=Auth::user()->distcode;
        $this->deptcode=Auth::user()->deptcode;
        $this->officecode=Auth::user()->officecode;
        $this->tot = PollingData::where('distcode', $this->distcode)
        ->where('deptcode', $this->deptcode)
        // ->where('subdeptcode',$this->subdeptcode)
        ->where('officecode', $this->officecode)->count();

        $this->emptype["regular"]= PollingData::      
        where('distcode', $this->distcode)
        ->where('deptcode', $this->deptcode)
        // ->where('subdeptcode',$this->subdeptcode)
        ->where('officecode', $this->officecode)
        ->where('EmpTypeId',1)->count();

        $this->emptype["contractual"]= PollingData::      
        where('distcode', $this->distcode)
        ->where('deptcode', $this->deptcode)
        // ->where('subdeptcode',$this->subdeptcode)
        ->where('officecode', $this->officecode)
        ->where('EmpTypeId',2)->count();
        
          return view('livewire.reports.undertaking');
    }
    public function undertaking_download(){

        $pdf=PDF::loadView('reports.pdfreports.undertaking',["tot" => $this->tot,"emptype"=>$this->emptype])
        ->setPaper('a4', 'portrait')->output();
        return response()->streamDownload(
            fn () => print($pdf),
            "undertaking.pdf"
        );
    }
}
