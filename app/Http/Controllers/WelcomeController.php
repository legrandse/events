<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;


class WelcomeController extends Controller
{
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    	
		 $prices = Price::all();
        return view('welcome',compact('prices'));
    }
}
