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
    	$owner = app('currentOwner');
    	if ($owner) {
	        setPermissionsTeamId($owner->id); //set current team according domain
	    }
    	$archiveDate = Settings::find(1)->value ? : 1825;
		$archiveSetDate = Carbon::now()->subDays($archiveDate)->toDateString();
    	
    	$users = User::all();
    	
    	$roles = Role::all();
    	
    	/*$events = Event::where('start','>=',$archiveSetDate)
    				->orderBy('start','ASC')
    				->get();
    	   	    	    	
    	$tasks = Task::orderBy('position','ASC')->get();
    	  */  	    	
    	$shifts = Shift::orderByRaw("
		    CASE 
		        WHEN start < '06:00:00' THEN 1 
		        ELSE 0 
		    END, start
		")->get();
		
		$events = Event::where('start', '>=', $archiveSetDate)
					    ->where('owner_id',$owner->id)
					    ->orderBy('start', 'ASC')
					    ->with([
					        'tasks' => function ($query) {
					            $query->orderBy('position', 'ASC')
					                  ->with([
					                      'shifts' => function ($q) {
					                          $q->orderByRaw("
					                              CASE 
					                                  WHEN start < '06:00:00' THEN 1 
					                                  ELSE 0 
					                              END, start
					                          ");
					                      }
					                  ]);
					        }
					    ])
					    ->get();
		//dd($events);
		
		$totalShiftsByEvents = Event::withCount([
		    'shifts',
		    'shifts as confirmed_shifts_count' => function ($query) {
		        $query->where('is_confirmed', 1);
		    },
		])->get()
		  ->keyBy('id')      // réindexe par l'ID de l'event
		  ->toArray();       // convertit en tableau
		
		//dd($totalShiftsByEvents);
		
    	
    	/*$topUsers = Shift::join('events','shifts.event_id', '=', 'events.id')
    		->where('events.start','>=',date('Y').'-01-01')
    		->where('shifts.user_id', '!=', 0)
		    ->groupBy('shifts.user_id')
		    ->havingRaw('COUNT(*) > 5')
		    ->selectRaw('shifts.user_id, COUNT(*) as count')
		    ->orderByDesc('count')
		    //->take(10)
		    ->get();
		 */
		 $topUsers = User::whereHas('shifts.task.event', function ($query) {
				        $query->where('start', '>=', date('Y') . '-01-01');
				    })
				    ->withCount(['shifts as total_shifts' => function ($query) {
				        $query->whereHas('task.event', function ($q) {
				            $q->where('start', '>=', date('Y') . '-01-01');
				        });
				    }])
				    ->having('total_shifts', '>', 5)
				    ->orderByDesc('total_shifts')
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
    	$userShiftStart = $userShiftStarts->groupBy('event_id')->map(fn($shifts) => $shifts->pluck('start')->toArray())->toArray();
    	
    	$userShiftEnd = auth()->user()->shifts->pluck('end','end')->toArray();
    	
    	/*$userShiftStart = [];
    	foreach($userShiftStarts as $shift)
    			{
    				$userShiftStart[$shift->event_id][] = $shift->start;
    			}
    	*/
    	$userIds = User::whereHas('shifts.task.event', function ($query) use ($archiveSetDate) {
	        $query->where('start', '>=', $archiveSetDate);
	    })
	    ->pluck('id');
    		
    	//retrieve user id filtered by task and shift
    	//$a = [];
    	
	   // dd($userIds);
/*
    	foreach($shifts as $shift)
    	{
    		$a[$shift->task_id][] = $shift->user_id;
    		
    	}*/
    	//dd($a);
    	$missingShift = [];
    	foreach($shifts as $shift)
    	{
    		$missingShift[$shift->event_id][] = $shift->user_id;
    		
    		
    	}
    	//dd($missingShift);
   							
    	
        return view('home',compact('users','events','totalShiftsByEvents','missingShift','roles','userShiftStart','userShiftEnd','archiveSetDate','xValues', 'yValues'));
    }
    
   
    
    
    
}
