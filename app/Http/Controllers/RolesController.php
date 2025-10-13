<?php

namespace App\Http\Controllers;

//use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RolesController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);

    }
	
	
	
	
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
            //dd($request);
            $roles = Role::orderBy('id','DESC')->paginate(5);

        	return view('roles.index',compact('roles'))

            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            $permission = Permission::get();
			return view('roles.create',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $data =  $request->validate([
			'name' => 'required|unique:roles,name',
			'permission' => 'required',
			 ]);
			//dd($data);
    		$role = Role::create(['name' => $data['name']]);
    		$permission = collect($data['permission'])->map(fn($val)=>(int)$val);
	        $role->syncPermissions($permission);

    		return redirect()->route('roles.index')
		            ->with('success','Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($subdomain, Role $role)
    {
        
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$role->id)
            ->get();

    	 return view('roles.show',compact('role','rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($subdomain, Role $role)
    {
        //$role = Role::find($role->id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
				            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
				            ->all();
        //dd($permission,$rolePermissions);    
        
          return view('roles.edit',compact('role','permission','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $subdomain, Role $role)
    {
            $data = $request->validate( [
            'name' => 'required',
            'permission' => 'required',
        ]);
        //dd($data);

        //$role = Role::find($id);
      //  $role->name = $request->input('name');
        $role->update($data);
		$permission = collect($data['permission'])->map(fn($val)=>(int)$val);
        $role->syncPermissions($permission);

        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($subdomain, Role $role)
    {
        Role::find($role->id)->delete();
        return redirect()->route('roles.index')
                         ->with('success','Role deleted successfully');
    }
}
