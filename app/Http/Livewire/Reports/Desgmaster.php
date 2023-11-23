<?php

namespace App\Http\Livewire\Reports;
use Illuminate\Support\Facades\Auth;
use App\Models\DesignationMaster;
use Livewire\Component;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\WithPagination;

class Desgmaster extends Component
{
    use WithPagination;
    public $headers=[];
    public $alldata=[];
    public $pdfdata;
    public $distcode;
    public $search="";
    public $perPage = 10;
    public function mount(){
        $this->distcode=Auth::user()->distcode;
         
     
    }


    public function desg_download()
    {
       
        // foreach($this->pdfdata as $emp){
        //     $desg[$emp->id]=$this->getDesignationTitle($emp->DesigCode);
        //     $payscale[$emp->id]=$this->getPayScaleTitle($emp->PayScaleCode);
        //     $pics[$emp->photoid]=$this->retrieveImage($emp->photoid);
        // }    

        $options = new Options();
        $options->set('isPhpEnabled', true); 
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); 
        $this->pdfdata=$this->alldata;
        $pdfContent = PDF::loadView('reports.pdfreports.desgmaster', ["headers" => $this->headers, "data" => $this->pdfdata])
        ->setPaper('a4', 'portrait')
        ->setWarnings(false)
        ->setOptions([$options])->output();

        
        
        return response()->streamDownload(
            fn () => print($pdfContent),
            "designationmaster.pdf"
        );
        // $pdf = Pdf::loadView('reports.report', $this->pdfdata->toArray());
        // return $pdf->download('invoice.pdf');
    }

    public function render()
    {
        $this->headers = [
            'Code', 'Designation Name', 'Can be Deployed as'];
        $data =  Designationmaster::where('distcode',$this->distcode)->when($this->search,function($query, $search){
                return $query->where('Designation','ILIKE',"%$this->search%");
         })->orderBy('id','ASC')->paginate($this->perPage);
        
        $this->alldata=Designationmaster::where('distcode', $this->distcode)->get();
        return view('livewire.reports.designationmaster',["data"=>$data]);
    }
}
