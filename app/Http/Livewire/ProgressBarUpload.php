<?php

namespace App\Http\Livewire;

use App\Models\PollingData;
use Illuminate\Support\Facades\DB;
use Livewire\Component;


class ProgressBarUpload extends Component
{
    public $completed = 0;
    public $total = 0;
    public $percentage = 0;
    public function mount($completed=0, $total=0)
    {
        $this->completed = $completed;
        $this->total = DB::table('hrms_polling_data')->whereNot('CLASS',4)->count();
       
    }
    

    // public function progressUpdated($data)
    // {
       
    //     $this->completed = $data['completed'];
    //     $this->total = $data['total'];
    //     if ($this->total > 0) {
    //         $this->percentage = floor(($this->completed / $this->total) * 100);
    //     }
    // }

 
    public function render()
    {
       $this->completed = PollingData::count();
        if($this->total>0)
        {
            $this->percentage = floor(($this->completed/$this->total)*100);
        }
        return view('livewire.progress-bar-upload',["completed"=>$this->completed,"total"=>$this->total, "percentage"=>$this->percentage]);
    }
}
