<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SubDomainController extends Controller
{
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $shortname)
    {
    	
        $owner = app('currentOwner');
    	
    	if ($owner) {	
		    setPermissionsTeamId($owner->id); //set current team according domain
		}
        
        
        return view('subDomain',compact('owner'));
    }
}
