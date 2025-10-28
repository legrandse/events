<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class WelcomeController extends Controller
{
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    	
		 $prices = Product::all();
        return view('welcome',compact('prices'));
    }
}
