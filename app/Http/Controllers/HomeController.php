<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:admin-dash', ['only' => ['dashboard']]);
    }

    public function home(Request $request)
    {
        return view('welcome');
    }


    public function dashboard(Request $request)
    {
        return view('dashboard');
    }
}
