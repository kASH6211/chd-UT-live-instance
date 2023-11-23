<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\DistMaster;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getDashboard()
    {
        $distcode = Auth::user()->distcode;
        $distname="";
        if($distcode)
        {
            $distname = DistMaster::where('DistCode',$distcode)->first()->DistName;

        }
        
        return view('dashboard',['distname'=>$distname]);
    }

    public function webCapture()
    {
        return view('webcapture');
    }
}
