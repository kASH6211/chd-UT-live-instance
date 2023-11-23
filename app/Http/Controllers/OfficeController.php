<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function officedetail($key)
    {
        return view('office.officedetail',["key"=>$key]);
    }
}
