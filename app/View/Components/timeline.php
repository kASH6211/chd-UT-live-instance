<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\ProjectHistory;

class timeline extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $projectid;
    public function __construct($id)
    {
        $this->projectid=$id;
    }
   

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $data=ProjectHistory::where("project_id","=",$this->projectid)->orderby("id","desc")->get();
        return view('components.timeline',["history"=>$data]);
    }
}
