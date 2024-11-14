<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){

        if(Auth::user()->usertype == 'skolens')
        {
            return('dashboard');
        }
        else{
            return view('skolotajs.home');
        }


    }
}
