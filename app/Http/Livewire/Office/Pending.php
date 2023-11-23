<?php

namespace App\Http\Livewire\Office;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\OfficeMaster;
use App\Models\DeptMaster;
use App\Models\SubdeptMaster;
use App\Models\OfficeLock;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf;

class Pending extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    public $distcode;
    public $search="";
    public $perPage = 15;
    public $headers=[];
    public $alldata=[];
    public $pdfdata;
    
    public function mount()
    {
        $this->distcode=Auth::user()->distcode ;
    }
    public function render()
    {
        $this->authorize('view',OfficeMaster::class);
        $this->headers=['Department','Sub-department','Office','Office Address'];

        $ids =  DB::table('office_masters')->leftJoin('polling_data', function ($join) {
            $join->on('office_masters.distcode', '=', 'polling_data.distcode')
                 ->on('office_masters.deptcode', '=', 'polling_data.deptcode')
                 ->on('office_masters.officecode', '=', 'polling_data.officecode');
        })
        ->where('office_masters.distcode', $this->distcode)
        ->where('polling_data.completed',1)
        ->pluck('office_masters.id') // Use pluck to get an array of IDs
        ->unique()->all();

        $data = OfficeMaster::where('distcode',$this->distcode)->whereNotIn('id', $ids)
        ->when($this->search,function($query, $search){
                         return $query->where('office','ILIKE',"%$this->search%");
                     })
                     ->orderBy('deptcode','asc')
                    ->orderBy('subdeptcode','asc')
                     ->orderBy('id','DESC')->select('deptcode','subdeptcode','office','address')->paginate($this->perPage);
            $data->withPath('/office/detail/pending');
        
            $tot =OfficeMaster::where('distcode',$this->distcode)->whereNotIn('id', $ids)->count();
        return view('livewire.office.pending',["data"=>$data,"header"=>$this->headers,"total"=>$tot]);
    }
    public function pending_download(){
        $options = new Options();
        $options->set('isPhpEnabled', true); 
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); 
        $ids =  DB::table('office_masters')->leftJoin('polling_data', function ($join) {
            $join->on('office_masters.distcode', '=', 'polling_data.distcode')
                 ->on('office_masters.deptcode', '=', 'polling_data.deptcode')
                 ->on('office_masters.officecode', '=', 'polling_data.officecode');
        })
        ->where('office_masters.distcode', $this->distcode)
        ->where('polling_data.completed',1)
        ->pluck('office_masters.id') // Use pluck to get an array of IDs
        ->all();
            $data = OfficeMaster::where('distcode',$this->distcode)->whereNotIn('id', $ids)
            ->when($this->search,function($query, $search){
                return $query->where('office','ILIKE',"%$this->search%");
            })
            ->orderBy('deptcode','asc')
            ->orderBy('subdeptcode','asc')
            // ->orderBy('id','DESC')
            ->get();
          $other=[];         
        foreach($data as $d){
            $n1=$this->getDeptName($d->deptcode);
            $n2=$this->getSubDeptName($d->deptcode,$d->subdeptcode);
            $other[$d->deptcode]=$n1;
            $other[$d->subdeptcode]=$n2;
        }
        
        $pdfContent = PDF::loadView('office.pdfs.pending', ["headers" => $this->headers, "data" => $data,"other"=>$other])
        ->setPaper('a4', 'portrait')
        ->setWarnings(false)
        ->setOptions([$options])->output();

        
        
        return response()->streamDownload(
            fn () => print($pdfContent),
            "pending-offices.pdf"
        );
       
    }
    public function updatedSearch()
    {
        $this->resetPage(); // Go back to the first page when search query changes
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
        $dept="";
        if($deptcode)
            $dept= DeptMaster::where('distcode',$this->distcode)->where('deptcode',$deptcode)->first();
        if($dept)
            return $dept->deptname;
        return null;
    }
}
