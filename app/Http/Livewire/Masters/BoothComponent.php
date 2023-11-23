<?php

namespace App\Http\Livewire\Masters;


use Livewire\Component;
//use App\Models\PayScale;
use App\Models\DistMaster;

use App\Models\ConsDist;
use App\Models\ConsList;
use App\Models\Booth;
use App\Models\BoothLocn;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BoothComponent extends Component
{

    use WithPagination;
    use AuthorizesRequests;
   
    public $search="";
    public $distlist;
    public $perPage = 250;
    public $newmodal = false;
    public $editmodal = false;
    public $viewmodal = false;
    public $confirmupdatemodal = false;
    //public $classlist;
    public $object =null ;
    public $editobject ;
    public $viewobject;
    public $distcode;
    public $aclist=[];
    public $sensitivitylist = null;
    public $urbanlist = null;
    public $locationslist = null;
    public function mount()
    {

        $this->distcode=Auth::user()->distcode;
       //$this->object=new Booth();
       //$this->editobject=new Booth();
        
        $this->distlist = DistMaster::all();
        
        $temp = ConsDist::where('distcode',$this->distcode)->orderBy('ac_no','ASC')->get();
       
        foreach($temp as $item)
        {
            $acno = $item->ac_no;
            if($acno<10)
            {   
                $acno = "0".$acno;
            }
            $item->ac_name = $item->ac_name." (".$acno.")";
            array_push($this->aclist,$item);
        }
        
        $this->sensitivitylist = [
            ["index"=>"Very Sensitive","title"=>"Critical"],
            ["index"=>"Ordinary","title"=>"Ordinary"],
            ["index"=>"Sensitive","title"=>"Vulnerable"],
        ];
        $this->urbanlist = [
            ["index"=>0,"title"=>"Rural"],
            ["index"=>1,"title"=>"Urban"],
        ];
        $this->loadLocations();

        $this->object['DEL'] = 'o';
        $this->object['DISTCODE_FROM'] = 0;
        $this->object['NOOFOFFICER'] = 4;
        $this->object['FEMALEPARTY'] = 0;
        $this->object['URBAN'] = 0;
        $this->object['PARDANASHIN'] = 0;
        $this->object['OtherVote'] = 0;

       // $this->classlist = ClassMaster::all();
            
    }


    public function render()
    {

     
        //$this->authorize('view',ConsDist::class);
        $header=['Constituency','Polling Station (Booth No.)','Polling Location (Location No.)','Village','Edit','Delete'];
        
          if($this->distcode)
          {
            $data =  Booth::where('DISTCODE',$this->distcode)->when($this->search,function($query){
                return $query->where('POLLBUILD','ILIKE',"%$this->search%");
            })->orderby('CONSCODE','ASC')->orderByRaw('CAST("BOOTHNO" AS INTEGER) ASC')->paginate($this->perPage);
            $data->withPath('/master/booth');
            $tot =  Booth::where('DISTCODE',$this->distcode)->count();
          }
          
          
          return view('livewire.masters.booth-component',["data"=>$data,"header"=>$header,"total"=>$tot,"distlist"=>$this->distlist]);
    }
      
    public function loadLocations()
    {
        if($this->object && $this->object['CONSCODE'])
        {
          $this->locationslist = BoothLocn::where('DISTCODE', $this->distcode)->where('CONSCODE',$this->object['CONSCODE'])->get();
        //  $this->object['BoothNo'] = 
        }
        else{
          $this->locationslist = BoothLocn::where('DISTCODE', $this->distcode)->get();
        }

        foreach ($this->locationslist as $item)
        {
          $item['LOCN_BLDG_EN'].= " (".$item['PS_LOCN_NO'].")";
        }
        $this->object['BOOTHNO']=$this->generateboothno();

    }

    public function addobject()
    {
        $this->object['DISTCODE']=$this->distcode;

        Validator::make($this->object, [
            'DISTCODE'=> ['required'],
            'CONSCODE' => ['required'],
            'BOOTHNO' => ['required'],
            'POLLBUILD' => ['required'],
            'URBAN' => ['required'],
            'PS_LOCN_NO' => ['required'],
            'VILLAGE' => ['required'],
            'POLLAREA' => ['required'],
            'NOOFOFFICER' => ['required','numeric'],
            'MALEVOTE' => ['required','numeric'],
            'FEMALEVOTE' => ['required','numeric'],
            'OtherVote'=> ['required','numeric'],
            'TYPE'=> ['required'],
        ],
        [
        'DISTCODE.required' => 'Selection of District is mandatory.',
        'CONSCODE.required' => 'Please select a constituency.',
        'BOOTHNO.required' => 'Please provide a valid Booth No.',
        'POLLBUILD.required' => 'Please provide a valid Booth Name.',
        'URBAN.required' => 'Selection of category is mandatory.',
        'PS_LOCN_NO.required' => 'Selection of location is mandatory.',
        'VILLAGE.required' => 'Village is mandatory.',
        'POLLAREA.required' => 'Poll area is mandatory.',
        'NOOFOFFICERS.required' => 'Number of officers is mandatory.',
        'MALEVOTE.required' => 'Male votes is mandatory.',
        'FEMALEVOTE.required' => 'Female votes is mandatory.',
        // Add more custom messages for other rules as needed.
    ])->validate();
       // $consdist=ConsDist::where('discode',$this->distcode)->get()->first();
       // $this->object['conscode']=$consdist->acname->AC_NAME;
       
   // $this->authorize('create',new ConsDist($this->object));
   //dd($this->object);
   $this->object['TOTALVOTE'] = $this->object['MALEVOTE'] + $this->object['FEMALEVOTE'] + $this->object['OtherVote'];
       Booth::create($this->object);
   
        $this->toggle('newmodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'New Polling Station Added successfully!'
        ]);
      
        $this->emit('close-banner');

       
    }
    public function generateboothno()
    {
        $boothno = "";
        if($this->object && $this->object['CONSCODE'])
        {
            $booth =  Booth::where('DISTCODE',$this->distcode)->where('CONSCODE',$this->object['CONSCODE'])->orderByRaw('CAST("BOOTHNO" AS INTEGER) DESC')->first();
            if($booth)
            {
                $boothno = intval($booth->BOOTHNO)+1;
            }
            else
            {
                $boothno = 1;
            }
        }
        
        return $boothno;
    }

    public function editobjectarray($id)
    {
       // $this->authorize('update',ConsDist::class);
       //$data = ConsDist::where('distcode',$this->distcode)->where('ac_no',$code)->first();
       //$this->authorize('update',$data);
       $data = Booth::find($id);
      // dd($this->editobject);
      if($data)
      {
        $this->editobject['id']= $id;
        $this->editobject['CONSCODE'] = $data->CONSCODE;
        $this->editobject['BOOTHNO'] = $data->BOOTHNO;
        $this->editobject['POLLBUILD'] = $data->POLLBUILD;
        $this->editobject['VILLAGE'] = $data->VILLAGE;
        $this->editobject['POLLAREA'] = $data->POLLAREA;
        $this->editobject['TOTALVOTE'] = $data->TOTALVOTE;
        $this->editobject['MALEVOTE'] = $data->MALEVOTE;
        $this->editobject['FEMALEVOTE'] = $data->FEMALEVOTE;
        $this->editobject['OtherVote'] = $data->OtherVote;
        $this->editobject['PS_LOCN_NO'] = $data->PS_LOCN_NO;
        $this->editobject['FEMALEPARTY'] = $data->FEMALEPARTY;
        $this->editobject['PARDANASHIN'] = $data->PARDANASHIN;
        $this->editobject['TYPE'] = $data->TYPE;
        if($data->URBAN ==1)
        {
            $this->editobject['URBAN'] = $data->URBAN;
        }
        else
        {
            $this->editobject['URBAN'] = 0;
        }
       
        $this->editobject['NOOFOFFICER'] = $data->NOOFOFFICER;
       $this->editobject['DISTCODE'] = $this->distcode;







      }
      
       $this->toggle('editmodal');
    }


    public function updatePS()
    {
       // $this->authorize('update',ConsDist::class);
       Validator::make($this->editobject, [
        'DISTCODE'=> ['required'],
        'CONSCODE' => ['required'],
        'BOOTHNO' => ['required'],
        'POLLBUILD' => ['required'],
        'URBAN' => ['required'],
        'PS_LOCN_NO' => ['required'],
        'VILLAGE' => ['required'],
        'POLLAREA' => ['required'],
        'NOOFOFFICER' => ['required','numeric'],
        'MALEVOTE' => ['required','numeric'],
        'FEMALEVOTE' => ['required','numeric'],
        'OtherVote'=> ['required','numeric'],
        'TYPE'=> ['required'],
    ],
    [
    'DISTCODE.required' => 'Selection of District is mandatory.',
    'CONSCODE.required' => 'Please select a constituency.',
    'BOOTHNO.required' => 'Please provide a valid Booth No.',
    'POLLBUILD.required' => 'Please provide a valid Booth Name.',
    'URBAN.required' => 'Selection of category is mandatory.',
    'PS_LOCN_NO.required' => 'Selection of location is mandatory.',
    'VILLAGE.required' => 'Village is mandatory.',
    'POLLAREA.required' => 'Poll area is mandatory.',
    'NOOFOFFICERS.required' => 'Number of officers is mandatory.',
    'MALEVOTE.required' => 'Male votes is mandatory.',
    'FEMALEVOTE.required' => 'Female votes is mandatory.',
    // Add more custom messages for other rules as needed.
])->validate();

    $this->editobject['TOTALVOTE'] = $this->editobject['MALEVOTE'] + $this->editobject['FEMALEVOTE'] + $this->editobject['OtherVote'];      
    $data = Booth::where('id',$this->editobject['id'])->first();
     //  $this->authorize('update',$data);
      
     
     $data->CONSCODE= $this->editobject['CONSCODE'] ;
     $data->BOOTHNO = $this->editobject['BOOTHNO'];
     $data->POLLBUILD=$this->editobject['POLLBUILD'];
     $data->VILLAGE=$this->editobject['VILLAGE'];
     $data->POLLAREA=$this->editobject['POLLAREA'];
     $data->TOTALVOTE=$this->editobject['TOTALVOTE'];
     $data->MALEVOTE=$this->editobject['MALEVOTE'];
     $data->FEMALEVOTE=$this->editobject['FEMALEVOTE'];
     $data->OtherVote=$this->editobject['OtherVote'];
     $data->PS_LOCN_NO=$this->editobject['PS_LOCN_NO'];
     $data->FEMALEPARTY=$this->editobject['FEMALEPARTY'];
     $data->PARDANASHIN=$this->editobject['PARDANASHIN'];
     $data->TYPE=$this->editobject['TYPE'];

     if($this->editobject['URBAN'] ==1)
     {
        $data->URBAN=  1;
     }
     else
     {
        $data->URBAN = 0;
     }
    
     $data->NOOFOFFICER=$this->editobject['NOOFOFFICER'];
    $data->save();
       
       $this->editobject = null;
        $this->toggle('editmodal');
       $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Polling Station Updated successfully!'
        ]);
      
        $this->emit('close-banner');


    }
    public function viewBooth($id)
    {
        $vo =$this->viewobject = Booth::find($id);
        $this->viewobject['CONSNAME'] = $vo->consname->ac_name;
        $this->toggle('viewmodal');

    }

    public function toggle($key)
    {
        switch($key)
        {
            case "viewmodal":
                $this->viewmodal = !$this->viewmodal;
                break;
            case "newmodal":
                $this->newmodal = !$this->newmodal;
                break;
            case "editmodal":
                $this->editmodal = !$this->editmodal;
                break;
                case "confirmupdatemodal":
                $this->confirmupdatemodal = !$this->confirmupdatemodal;
                break;
        }
    } 

    public function openForDeletion($id)
    {
        //$this->authorize('delete',ConsDist::class);
        $data = Booth::find($id);
      //  $this->authorize('delete',$data);
      $this->editobject['id'] = $id;
      $this->editobject['POLLBUILD'] = $data->POLLBUILD;
      $this->editobject['BOOTHNO'] = $data->BOOTHNO;
      $this->editobject['VILLAGE'] = $data->VILLAGE;
      $this->editobject['PS_LOCN_NO'] = $data->PS_LOCN_NO;
      $this->editobject['URBAN'] = $data->URBAN;
      $this->editobject['TOTALVOTE'] = $data->TOTALVOTE;
      $this->editobject['TYPE'] = $data->TYPE;
      $this->editobject['CONSCODE'] = $data->CONSCODE;
        $this->toggle('confirmupdatemodal');
    }
    public function deleteRecord($id)
    {
       // $this->authorize('delete',ConsDist::class);
        $del = Booth::find($id);
       // $this->authorize('delete',$del);
        $del->delete();
       $this->editobject = null;

        $this->toggle('confirmupdatemodal');
        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Polling Station Removed Successfully!'
        ]);
        $this->emit('close-banner');
    }
   

    
}
