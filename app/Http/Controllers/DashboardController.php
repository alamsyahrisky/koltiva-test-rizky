<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        if(Auth::check()){
            return view('pages.dashboard');
        }
    
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
}
