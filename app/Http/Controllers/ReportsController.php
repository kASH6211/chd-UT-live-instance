<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function customchecklistdata()
    {
        return view('reports.customizedchecklist');
    }

    public function undertaking(){

        return view('reports.undertaking');
    }
    public function exemptionlist()
    {
        return view('reports.exemptionlist');
    }
    public function emailchecklist()
    {
        return view('reports.emailchecklist');
    }

    public function designationmaster(){
       
        return view('reports.designationmaster');
    } 

    public function payscalemaster(){
        return view('reports.paymaster');
    }
}
