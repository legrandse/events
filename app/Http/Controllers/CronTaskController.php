<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use App\Models\Event;
use App\Models\User;
use App\Models\Shift;
use Carbon\Carbon;
use App\Jobs\TaskReminder;
use App\Jobs\MissingShiftReminder;
use Illuminate\Support\Facades\Crypt;
use DB;

class CronTaskController extends Controller
{
    public function executeTask()
    {
    	$exitCode = Artisan::call('queue:work --stop-when-empty', []);
    }
    
    public function taskReminder()
    {
    	
    	
    	$today = date('Y-m-d');
    	
    	$date_reminder = Carbon::create($today)->addDays(request('days'))->toDateString();
    	
    	$event = Event::where('start',$date_reminder)->firstOrFail();
    	
    	$shifts = Shift::where('event_id',$event->id)
		    				->get()->pluck('user_id')->toArray();
		$users = User::where('email','!=',null)->get();
		  	
		//retreive users with jobs
			$users_with_jobs = [];
		   		foreach($users as $user)
			    {
			    	$in_array = in_array($user->id ,$shifts);
				    	if($in_array == TRUE)
				    	{
				    		$users_with_jobs[] = [
				    		'id' => $user->id,
				    		'email'=>$user->email,
			    			'name'=>$user->name,
			    			'firstname'=>$user->firstname,
			    			'phone'=>$user->phone,
				    		];
				    	}
					
			    }
			   
    	//dd($users_with_jobs);
    		foreach($users_with_jobs as $user)
    		{
         		$key = Crypt::encryptString($user['phone']);
				$urlToDashBoard = route('appredirect',['key'=>$key]);
				
				$userShift = User::find($user['id'])->shifts->where('event_id',$event->id);
				//dd($userShift);
				
				
	         	dispatch(new TaskReminder($user,$event,$userShift,$urlToDashBoard))
			         	->delay(now()->addSeconds(3));
			}		
				
		
			return ;
    	
    	
    }
    
    public function missingShiftReminder()
    {
    	$today = date('Y-m-d');
    	
    	$date_reminder = Carbon::create($today)->addDays(request('days'))->toDateString();
    	
    	$event = Event::where('start',$date_reminder)->firstOrFail();
    	
    	
    	$shifts = Shift::where('event_id',$event->id)
    					->where('user_id',0||null)
    					->get();
    	//dd($shifts);				
    					
		$users = User::role(2)->get(); //to the comité
		
		
		
			foreach($users as $user)
			{
					if(!$shifts->isEmpty()){
						$key = Crypt::encryptString($user->phone);
						$urlToDashBoard = route('appredirect',['key'=>$key]);
						$urlToDashBoard .= '#collapse'.$event->id;
						
							
				         	dispatch(new MissingShiftReminder($user,$event,$shifts,$urlToDashBoard))
						         	->delay(now()->addSeconds(3));
					}
				
			}
		
    	
    }
    
    
    
}
