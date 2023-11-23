<?php

namespace App\Http\Livewire\Reports;

use App\Http\Livewire\Masters\Department;
use App\Models\DeptMaster;
use App\Models\OfficeMaster;
use App\Models\PollingData;
use App\Models\PollingDataPhoto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf;


class Exemptionlist extends Component
{
    use WithPagination;
    public $distcode;
    public $deptcode;
    public $officecode;
    public $alldeptlist;
    public $allofficelist;
    public $filterofficelist;
    public $search;
    public $reportdata=[];
    public $exemptmodal;
    public $empid;
    public $Remarks;

    public $perPage = 10;

    public function mount()
    {
       
        $this->distcode = Auth::user()->distcode;
        $this->alldeptlist=DeptMaster::where('distcode',$this->distcode)->get();    
        $this->allofficelist=OfficeMaster::where('distcode',$this->distcode)->get();
        $this->reportdata = PollingData::where('distcode', $this->distcode)->where('del','d')->get();
        // $this->filterofficelist=$this->allofficelist;  
    }
    public function deptchange(){
        if($this->deptcode!=""){
        $this->filterofficelist=OfficeMaster::where('distcode',$this->distcode)
        ->where('deptcode',$this->deptcode)->get();
        }
        else{
            $this->deptcode=null;
            $this->officecode=null;
            $this->filterofficelist=null;   
        }
    }
    public function officechange(){
        if($this->officecode==""){
            $this->officecode=null;
        }    
    }
    public function removeexemptobject(){
        if($this->empid){
            $parts = explode('-->', $this->empid->Remarks);
            $firstPart = $parts[0];  
            $this->empid->Remarks=$firstPart;
            $this->empid->del='o';
            $this->empid->save();
            $this->toggle();
        }
    }
    public function exemptobject(){
        $data=["Remarks"=>$this->Remarks];
        Validator::make($data, [
            'Remarks'=> ['required','string']
        ],
        [
        'Remarks.required' => 'Remarks for Exemption is mandatory.',
        // Add more custom messages for other rules as needed.
     ])->validate();
    
        if($this->empid){
            $this->empid->Remarks=$this->empid->Remarks."-->".$this->Remarks;
            $this->empid->del='d';
            $this->empid->save();
            $this->toggle();
        }

    }
    
    public function getdata($id){
         $this->empid=PollingData::find($id);
        $this->toggle();
    }
    public function toggle(){
        $this->exemptmodal=!$this->exemptmodal;
        $this->Remarks="";
    }
    public function getOfficeName($distcode,$deptcode,$officecode)
    {
        $office=OfficeMaster::where('distcode',$distcode)->where('deptcode',$deptcode)->where('officecode',$officecode)->first();
        return $office->office;
    }

    public function exempt_download()
    {
       
        // foreach($this->pdfdata as $emp){
        //     $desg[$emp->id]=$this->getDesignationTitle($emp->DesigCode);
        //     $payscale[$emp->id]=$this->getPayScaleTitle($emp->PayScaleCode);
        //     $pics[$emp->photoid]=$this->retrieveImage($emp->photoid);
        // }    
        $header = ['Name','Father/Husband Name','Mobile','Class','Reason For Exemption'];
            
        $options = new Options();
        $options->set('isPhpEnabled', true); 
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); 
        $off=[];
        foreach($this->reportdata as $e){
            $off[$e->id]=$this->getofficeName($e->distcode,$e->deptcode,$e->officecode);
        }
        $pdfContent = PDF::loadView('reports.pdfreports.exemptlist', ["headers" => $header, "data" => $this->reportdata,"off"=>$off])
        ->setPaper('a4', 'portrait')
        ->setWarnings(false)
        ->setOptions([$options])->output();

        
        
        return response()->streamDownload(
            fn () => print($pdfContent),
            "ExemptionList.pdf"
        );
        // $pdf = Pdf::loadView('reports.report', $this->pdfdata->toArray());
        // return $pdf->download('invoice.pdf');
    }

    public function render()
    {

        $header = ['Name','Father/Husband Name','Mobile','Department','Office','Designation','Reason For Exemption'];
        
        $query = PollingData::where('distcode', $this->distcode)->where('del','d');
        if ($this->deptcode) {
            $query->where('deptcode', $this->deptcode);
        }
    
        if ($this->officecode) {
            $query->where('officecode', $this->officecode);
        }
    
        if ($this->search) {
            $s=$this->search;
            $query->where(function ($subquery) use ($s) {
                $subquery->where('Name', 'ILIKE', "%$this->search%")
                ->orwhere('FName', 'ILIKE', "%$this->search%")
                ->orwhere('hrmscode', 'ILIKE', "%$this->search%")
                ->orwhere('mobileno', 'ILIKE', "%$this->search%");
            });
        }
        $result=$query->orderBy('id', 'DESC')->paginate($this->perPage);
             
     
        return view('livewire.reports.exemptionlist',['header'=>$header ,
        "result"=>$result,"data"=>$this->reportdata]);
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
        return "Photo";

    }
}
