<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class SubDomainController extends Controller
{
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    	/*$users = User::all();
    	$events = Event::all();
    	$tasks = Task::orderBy('position','ASC')->get();
    	$shifts = Shift::all();
    	$shiftNotSent = Shift::where('is_sent',0)
    						  ->get()->count();
    						  */
		//dd($shiftNotSent);
        return view('subDomain');
    }
}
