<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportController extends Controller
{
    
    public function index()
    {
        return view('import.index');
    }

    public function connection(){
        return view('import.connection');
    }
   
    public function importhrmsdata()
    {
        return view('import.hrmsdata');
    }
}
