<?php

// app/Http/Livewire/WebcamCapture.php

// app/Http/Livewire/WebcamCapture.php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class WebcamCapture extends Component
{
    use WithFileUploads;

    public $photo;
    public $x=0;

    public function render()
    {
        return view('livewire.webcam-capture');
    }

    public function capturePhoto()
    {
       
      $this->x=1;
            //$filename = 'captured_' . time() . '.' . $this->photo->getClientOriginalExtension();
    
            // Store the photo in the livewire-tmp folder
            // $this->photo->store('livewire-tmp');
    
            // session()->flash('success', 'Photo captured successfully.');
        
    }
}
