<?php

namespace App\View\Components\Configuration;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\PortalConfiguration;


class LoginPageFooterText extends Component
{
    /**
     * Create a new component instance.
     */
    public $footertext = "";
    public function __construct()
    {
        $footer = PortalConfiguration::where('name','footertext')->first();
        $this->footertext =  $footer->value;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.configuration.login-page-footer-text');
    }
}
