<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OwnerUser;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use DB;
use Hash;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Crypt;
use Propaganistas\LaravelPhone\PhoneNumber;

class UsersController extends Controller
{
	use HasRoles;
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);

    }
	
	
	
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    	
    	
    	/*$owner = app('currentOwner');
        $users = User::orderBy('id','DESC')->paginate(5);
        $usersByOwner = OwnerUser::where('owner_id', $owner->id)
        				->orderBy('id','DESC')->paginate(5);*/
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    	
    	if($request['single'] == 1)
    	{
    		 $input = $request->validate([
            'name' => 'required',
            'firstname' => 'required',
           // 'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|unique:users,phone',
            'phone' => 'nullable',
            'email' => 'nullable',
            'password' => 'nullable',
            'roles' => 'required'
        ]);
    	}
    	else{
        $input = $request->validate([
            'name' => 'required',
            'firstname' => 'required',
           // 'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|unique:users,phone',
            'phone' => 'required|min:9|unique:users,phone',
            'email' => 'required|email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
		
        $input['phone'] = str_replace(array('.', '/',' ',','), '', $input['phone']);
        $input['password'] = Hash::make($input['password']);
    	}
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($subdomain, string $id)
    {
    	$user_id = Crypt::decryptString($id);
    	$user = User::find($user_id);
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($subdomain, string $id)
    {
    	$user_id = Crypt::decryptString($id);
    	//dd($user_id);
        $user = User::find($user_id);
        if($user->phone){
        $phone = new PhoneNumber($user->phone, $user->phone_country);
        $phone = $phone->formatForMobileDialingInCountry('BE');
		}
		else {
			$phone = '';
		}
       //dd($user->phone);
       
       	$roles = Role::pluck('name','name')->all();
       //dd($user);
        $userRole = $user->roles->pluck('name','name')->all();
    	$countries = ['BE'=>'Belgique +32','FR'=>'France +33', 'NL'=>'Pays-Bas +31', 'LU'=>'Luxembourg +352', 'DE'=>'Allemagne +49'];
    	//dd($roles,$userRole);
        return view('users.edit',compact('user','roles','userRole','countries','phone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$subdomain, string $id)
    {
    if(!$request['social'])
    {
     $data =   $request->validate([
            'name' => 'required',
            'firstname' => 'required',
            'email' => 'required|email',
            'phone_country' => 'required_with:phone',
            'phone' => 'phone:LENIENT|unique:users,phone,'.$id,
            'password' => 'same:confirm-password',
        	'roles' => 'nullable',  
        ]);
        
		}
	else {
		$data =   $request->validate([
            'name' => 'required',
            'firstname' => 'nullable',
            'email' => 'required|email',
            'phone_country' => 'required_with:phone',
            'phone' => 'phone:LENIENT|unique:users,phone,'.$id,
            'password' => 'nullable',
            'roles' => 'nullable'
        ]);
		
	}   
   		$phone = new PhoneNumber($data['phone'], $data['phone_country']);
		$data['phone'] = $phone->formatForMobileDialingInCountry($data['phone_country']);
    //dd($data);
        
        if(!empty($data['password'])){ 
            $data['password'] = Hash::make($data['password']);
        }else{
            $data = Arr::except($data,array('password'));    
        }
    	
    	//update user
        $user = User::find($id);
        $user->update($data);
        
        
        //update user role
        //first delete the role
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    	//reattribute the role
    	if(isset($data['roles'][0]))
    	{
    		$role = $data['roles'];
    		//dd($role);
    	}
    	else {
    		$role = 'Bénévole';
    		//dd($role);
    	}
    	$user->assignRole($role);
    	
    	
    	//dd(auth()->user()->roles->pluck('name')[0]);
    	if(auth()->user()->roles->pluck('name')[0] === 'Admin')
    	{
    		$route = 'users.index';
    	}
    	else
    	{
    		$route = 'home';
    	}
        return redirect()->route($route)
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($subdomain, User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}
