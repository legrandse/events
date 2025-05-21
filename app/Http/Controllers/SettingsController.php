<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;

class SettingsController extends Controller
{
	function __construct()
    {
         $this->middleware('permission:shift-list|shift-create|shift-edit|shift-delete', ['only' => ['index','show']]);
         $this->middleware('permission:shift-create', ['only' => ['create','store']]);
         $this->middleware('permission:shift-edit', ['only' => ['edit','update','massupdate','singleupdate']]);
         $this->middleware('permission:shift-delete', ['only' => ['destroy']]);
    }
    
    
    public function index()
    {
    	return view('settings');
	}
}
