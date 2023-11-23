<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProgressBar extends Component
{
    public $completed = 0;
    public $total = 0;
    public $percentage = 0;
    public function mount($completed=0, $total=0)
    {
        $this->completed = $completed;
        $this->total = $total;
        if($this->total>0)
        {
            $this->percentage = floor(($this->completed/$this->total)*100);
        }
    }
    protected $listeners = ['progressUpdated'];

    public function progressUpdated($data)
    {
       
        $this->completed = $data['completed'];
        $this->total = $data['total'];
        if ($this->total > 0) {
            $this->percentage = floor(($this->completed / $this->total) * 100);
        }
    }

    public function render()
    {
        return view('livewire.progress-bar',["completed"=>$this->completed,"total"=>$this->total, "percentage"=>$this->percentage]);
    }
}
