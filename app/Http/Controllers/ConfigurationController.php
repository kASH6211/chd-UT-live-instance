<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function portalConfiguration()
    {
        return view('configuration.portal');
    }
}
