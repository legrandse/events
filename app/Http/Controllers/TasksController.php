<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Event;
use App\Models\Shift;
use Illuminate\Http\Request;

class TasksController extends Controller
{
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
         $this->middleware('permission:task-list|task-create|task-edit|task-delete', ['only' => ['index','show']]);
         $this->middleware('permission:task-create', ['only' => ['create','store']]);
         $this->middleware('permission:task-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:task-delete', ['only' => ['destroy']]);

    }
	
	
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    	$event_id = request('event_id');
         return view('tasks.create', compact('event_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'event_id' => 'required',
            'description'=> 'sometimes',
        ]);
    
        Task::create($request->all());
    
        return redirect('home#collapse'.request('event_id'))
                        ->with('success','Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($subdomain, Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($subdomain, Task $task)
    {
        return view('tasks.edit',compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $subdomain, Task $task)
    {
    	
        $data = $request->validate([
            'name' => 'required',
            'description'=> 'sometimes',
            'position' => 'required',
        ]);
    
        $task->update($data);
    
        return redirect('home#collapse'.$task->event_id)
                        ->with('success','Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($subdomain, Task $task)
    {	
    	Shift::where('task_id',$task->id)->delete();
        $task->delete();
        
	        return redirect()->route('home')
	                        ->with('success','Task deleted successfully');
    }
}
