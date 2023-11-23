<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Crypt;

class select extends Component
{
    public $ddlist;
    public $idfield;
    public $textfield;
   
    public function __construct($ddlist,$idfield,$textfield)
    {
      
        $this->ddlist=$ddlist;
       
        $this->idfield=$idfield;
        $this->textfield=$textfield;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        
        return view('components.select',["ddlist"=>$this->ddlist,"idfield"=>$this->idfield,"textfield"=>$this->textfield]);
    }
}
