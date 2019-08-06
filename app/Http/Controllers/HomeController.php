<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lugar;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('home.redirect');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lugares = Lugar::all();
        return view('home', compact('lugares'));
    }
}
