<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner;
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
    	if($shortname == 'www'){
    		$owner = 'www';
    		return view('welcome',compact('owner'));
    	}
    	else {
    	$owner = Owner::where('shortname', $shortname)->first();
		}
		
        if (! $owner) {
            throw new NotFoundHttpException("Ce sous-domaine n'existe pas.");
        }
        app()->instance('currentOwner', $owner);
        
        return view('subDomain',compact('owner'));
    }
}
