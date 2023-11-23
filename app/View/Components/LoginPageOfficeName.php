<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\PortalConfiguration;

class LoginPageOfficeName extends Component
{
    /**
     * Create a new component instance.
     */
    public $officename="";
    public function __construct()
    {
        $office = PortalConfiguration::where('name','loginpagetext')->first();
        $this->officename =  $office->value;
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.login-page-office-name');
    }
}
