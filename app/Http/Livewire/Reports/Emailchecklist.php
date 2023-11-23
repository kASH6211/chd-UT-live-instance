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

class Emailchecklist extends Component
{
    use WithPagination;
    public $distcode;
    public $deptcode;
    public $officecode;
    public $alldeptlist;
    public $allofficelist;
    public $filterofficelist;
    public $search;
    public $exemptmodal;
    public $empid;
    public $Remarks;
    public $perPage = 10;

    public function mount()
    {
       
        $this->distcode = Auth::user()->distcode;
        $this->alldeptlist=DeptMaster::where('distcode',$this->distcode)->get();    
        $this->allofficelist=OfficeMaster::where('distcode',$this->distcode)->get();
        
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

    public function blankemail_download($id)
    {
        
        $q = OfficeMaster::where('distcode', $this->distcode);
        
        if($id==0){
            $q->where('EmailID','=',null)->get();
        }
        if($id==1){
            $q->where('EmailID','!=',null)->get();
        }
        $data=$q->get(); 
        $header =  ['Office','Address','Official EmailID'];
            
        $options = new Options();
        $options->set('isPhpEnabled', true); 
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); 
       
        $pdfContent = PDF::loadView('reports.pdfreports.emaillist', ["headers" => $header, "data" => $data])
        ->setPaper('a4', 'portrait')
        ->setWarnings(false)
        ->setOptions([$options])->output();

        
        
        return response()->streamDownload(
            fn () => print($pdfContent),
            "EmailCheckList.pdf"
        );
        // $pdf = Pdf::loadView('reports.report', $this->pdfdata->toArray());
        // return $pdf->download('invoice.pdf');
    }

    public function render()
    {
        $header = ['Office','Address','Official EmailID'];
        
        $query = OfficeMaster::where('distcode', $this->distcode);
        if ($this->deptcode) {
            $query->where('deptcode', $this->deptcode);
        }
        if ($this->officecode) {
            $query->where('officecode', $this->officecode);
        }
    
        $result=$query->orderBy('id', 'DESC')->paginate($this->perPage);
        $result->withPath('/reports/emailchecklist');
        
        return view('livewire.reports.emailchecklist',['header'=>$header ,
        "result"=>$result]);
   
    }
}
