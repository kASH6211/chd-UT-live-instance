<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class MastersController extends Controller
{
    public function statemaster()
    {
        return view('masters.state');
    }
    public function districtmaster()
    {
        return view('masters.district');
    }
    public function designationmaster()
    {
        return view('masters.designation');
    }
     public function payscalemaster()
    {
        return view('masters.payscale');
    }
     public function departmentmaster()
    {
        return view('masters.department');
    }
    public function subdepartmentmaster()
    {
        return view('masters.subdepartment');
    }
    public function districtconstituencymaster()
    {
        return view('masters.consdist');
    }

    public function officemaster()
    {
        return view('masters.office');
    }
    public function boothmaster()
    {
        return view('masters.booth');
    }
    public function boothlocnmaster()
    {
        return view('masters.boothlocn');
    }
    
    
}
