<?php

namespace App\Http\Livewire\Reports;

use App\Models\DesignationMaster;
use Livewire\WithPagination;
use App\Models\PollingData;
use App\Models\PollingDataPhoto;
use App\Models\PayScale;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Customizedchecklist extends Component
{
    use WithPagination;

    public $distcode='';
    public $deptcode = '';
    // public $subdeptcode = '0017';
    public $officecode = '';
    public $pdfdata;

    public $perPage = 10;
    public $headers;
    public $photos;
    public $tot;
   
    public function mount()
    {   
        $this->distcode=Auth::user()->distcode;
        $this->deptcode=Auth::user()->deptcode;
        $this->officecode=Auth::user()->officecode;
       
        $this->headers = [
            'S. No.', 'Dept.Sl.No.', 'Part No.', 'Sl. No', 'Regd.Voter Const.',
            'Name', 'Father\'s Name', 'Designation', 'Gender', 'Bank A/c No.', 'IFSC code', 'Bank Name',
            'Photograph', 'Emp Type Name',
            'Department', 'Office', 'Data Exported', 'EPIC No', 'DDO code',
            'Pay Scale', 'Basic Pay', 'Class', 'Aadhaar No', 'HRMS code',
            'Const. under Office falls', 'Office Address', 'Mobile Number', 'eMail ID', 'IFMS code',
            'Home Const.', 'Res Const', 'Res. Address', 'DOB',
            'Whether exercised elec.', 'Currently Selected As',
            'Whether on Long Leave', 'Retire Date', 'Handicap', 'Remarks'
        ];
        $data = PollingData::where('distcode', $this->distcode)
            ->where('deptcode', $this->deptcode)
            // ->where('subdeptcode',$this->subdeptcode)
            ->where('officecode', $this->officecode)->where('completed',1)
            ->orderBy('id', 'DESC')->get();
        //   $data->withPath('/reports/cutomizechecklist');
        
        $this->tot = PollingData::where('distcode', $this->distcode)->count();
        $this->pdfdata = $data;
    }

    public function downloadpdf()
    {
       
        foreach($this->pdfdata as $emp){
            $desg[$emp->id]=$this->getDesignationTitle($emp->DesigCode);
            $payscale[$emp->id]=$this->getPayScaleTitle($emp->PayScaleCode);
            $pics[$emp->photoid]=$this->retrieveImage($emp->photoid);
        }    

        $options = new Options();
        $options->set('isPhpEnabled', true); 
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); 

        $pdfContent = PDF::loadView('reports.pdfreports.customchecklist', ["headers" => $this->headers, "data" => $this->pdfdata,"pic"=>$pics,"desg"=>$desg,"payscale"=>$payscale])
        ->setPaper('a4', 'landscape')
        ->setWarnings(false)
        ->setOptions([$options])->output();

        
        
        return response()->streamDownload(
            fn () => print($pdfContent),
            "customchecklist.pdf"
        );
        // $pdf = Pdf::loadView('reports.report', $this->pdfdata->toArray());
        // return $pdf->download('invoice.pdf');
    }

    public function getPayScaleTitle($payscalecode)
    {
        $title = PayScale::find(['PayScaleCode' => $payscalecode, 'distcode' => $this->distcode])->first()->PayScale;
        return $title;
    }

    public function getDesignationTitle($desgcode)
    {
        $title = DesignationMaster::where('DesigCode' , $desgcode) ->  where('distcode',  $this->distcode)->first()->Designation;
        return $title;
    }

    public function retrieveImage($imageid)
    {
        
      if($imageid)
      {
        $pdp =  PollingDataPhoto::where('id',$imageid)->first();
        if($pdp)
        {
           
            return stream_get_contents($pdp->empphoto);
        }
        
      }
        return null;

    }


    public function render()
    {
        $data = PollingData::where('distcode', $this->distcode)
        ->where('deptcode', $this->deptcode)
        // ->where('subdeptcode',$this->subdeptcode)
        ->where('officecode', $this->officecode)->where('completed',1)
        ->orderBy('id', 'DESC')
      ->paginate($this->perPage);
        return view('livewire.reports.customizedchecklist', ["headers" => $this->headers, "data" => $data, "tot" => $this->tot]);
    }
}
