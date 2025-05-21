<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Task;
Use App\Models\Shift;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
         $this->middleware('permission:event-list|event-create|event-edit|event-delete', ['only' => ['index','store']]);
         $this->middleware('permission:event-create', ['only' => ['create','store']]);
         $this->middleware('permission:event-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:event-delete', ['only' => ['destroy']]);
    }
    
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->paginate(5);
        return view('events.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    	$roles = Role::all();
        return view('events.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    	
        $data = $request->validate([
            'name' => 'required',
            'start' => 'required',
           'attendee' => 'required',
        ]);
    	
    	
        Event::create($data);
    
        return redirect()->route('home')
                        ->with('success','Event created successfully.');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
    	$roles = Role::all();
        return view('events.edit',compact('event','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'name' => 'required',
            'start' => 'required|date',
            'attendee'=> 'required'
            
        ]);
    	//dd($data);
        $event->update($data + [
        'submited'=> $request->has('submited'),
        ]);
    
        return redirect()->route('home')
                        ->with('success','Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        Task::where('event_id',$event->id)->delete();
        Shift::where('event_id',$event->id)->delete();
        
	        return redirect()->route('home')
	                        ->with('success','Event deleted successfully');
    }
}
