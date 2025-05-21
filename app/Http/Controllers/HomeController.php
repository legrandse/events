<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Task;
use App\Models\Shift;
use App\Models\User;
use App\Models\Settings;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    	$archiveDate = Settings::find(1)->value ? : 1825;
		$archiveSetDate = Carbon::now()->subDays($archiveDate)->toDateString();
    	
    	$users = User::all();
    	
    	$events = Event::where('start','>=',$archiveSetDate)
    				->orderBy('start','ASC')
    				->get();
    	//dd($events);    	    	    	
    	$tasks = Task::orderBy('position','ASC')->get();
    	
    	$roles = Role::all();
    	
    	$shifts = Shift::orderBy('start','ASC')->get();
    	
    	$topUsers = Shift::join('events','shifts.event_id', '=', 'events.id')
    		->where('events.start','>=',date('Y').'-01-01')
    		->where('shifts.user_id', '!=', 0)
		    ->groupBy('shifts.user_id')
		    ->havingRaw('COUNT(*) > 5')
		    ->selectRaw('shifts.user_id, COUNT(*) as count')
		    ->orderByDesc('count')
		    //->take(10)
		    ->get();
		    
		//dd($topUsers);
		
		$xValues = [];
	    $yValues = [];
	    foreach ($topUsers as $userData) {
	        $user = User::find($userData->user_id);
	        if ($user) {
	            
	                $xValues[] = [$user->firstname];
	                $yValues[] = [$userData->count];
	            
	        }
	    }
    	
    	//$userShiftStart = auth()->user()->shifts->pluck('start','event_id')->toArray();
    	
    	$userShiftStarts = auth()->user()->shifts;
    	//$userShiftStart = $userShiftStarts->groupBy('event_id')->map(fn($shifts) => $shifts->pluck('start')->toArray())->toArray();
    	
    	$userShiftEnd = auth()->user()->shifts->pluck('end','end')->toArray();
    	
    	$userShiftStart = [];
    	foreach($userShiftStarts as $shift)
    			{
    				$userShiftStart[$shift->event_id][]=$shift->start;
    			}
    		
    	//retrieve user id filtered by task and shift
    	$a = [];
    	foreach($shifts as $shift)
    	{
    		$a[$shift->task_id][] = $shift->user_id;
    		
    	}
    	//dd($a);
    	$missingShift = [];
    	foreach($shifts as $shift)
    	{
    		$missingShift[$shift->event_id][] = $shift->user_id;
    		
    		
    	}
    //	dd($missingShift);
   							
    	
        return view('home',compact('users','events','tasks','shifts','a','roles','userShiftStart','userShiftEnd','missingShift','archiveSetDate','xValues', 'yValues'));
    }
    
   
    
    
    
}
