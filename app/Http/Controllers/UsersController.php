<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function users()
    {
        return view('users.users');
    }
    public function privileges()
    {
        return view('users.privileges');
    }
   
}
