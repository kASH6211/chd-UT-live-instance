<?php

namespace App\Http\Livewire\Transactions;

use Livewire\Component;

class CameraComponent extends Component
{
    public $viewmodal = false;
    public $capturedImage;
    public $selectedOption = 'computer'; // Default selection
    
    public function render()
    {
        return view('livewire.transactions.camera-component');
    }
    public function sendImageToParent()
    {
        $this->emit('imageFromChild', $this->capturedImage);
    }
    public function openCamera()
    {
        
        $this->dispatchBrowserEvent('startCamera');
        $this->toggle('viewmodal');
    }
    public function printh()
    {
        dd($this->capturedImage);
    }
    public function captureImage()
    {
        $this->dispatchBrowserEvent('capture');

        $this->toggle('viewmodal');
    }
    public function toggle($key)
    {
       
        switch($key)
        {
            case "viewmodal":
                $this->viewmodal = !$this->viewmodal;
                break;
        }
    } 
   
}
