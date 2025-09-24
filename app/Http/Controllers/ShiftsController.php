<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\User;
use App\Models\Task;
use App\Models\Event;
use App\Http\Controllers\SMSController;
use Illuminate\Http\Request;
use App\Mail\ShiftSent;
use App\Mail\UserShift;
use App\Jobs\SendShifts;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use DB;
use MagicLink\Actions\LoginAction;
use MagicLink\MagicLink;
use Rogervila\ArrayDiffMultidimensional;
use Illuminate\Support\Facades\Crypt;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;
use AshAllenDesign\ShortURL\Facades\ShortURL;
use Propaganistas\LaravelPhone\PhoneNumber;


use App\Http\Controllers\ICALController;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event as ICALEvent;
use Spatie\IcalendarGenerator\Enums\Display;
use DateTime;
use Carbon\Carbon;

class ShiftsController extends Controller
{
	use HasRoles;
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
         $this->middleware('permission:shift-list|shift-create|shift-edit|shift-delete', ['only' => ['index','show']]);
         $this->middleware('permission:shift-create', ['only' => ['create','store']]);
         $this->middleware('permission:shift-edit', ['only' => ['edit','update','massupdate','singleupdate']]);
         $this->middleware('permission:shift-delete', ['only' => ['destroy']]);
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
    	$task_id = request('task_id');
       return view('shifts.create',compact('event_id','task_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    	//dd($request);
       $data = $request->validate([
            
            'start' => 'required',
            'end'=> 'required',
            'nbr_user_id' => 'required',
           	'event_id' => 'required',
            'task_id' => 'required',
        ]);
       
    for($i = 0 ; $i < $data['nbr_user_id']; $i++){
    
        Shift::create($data);
		}
		
		
		Event::where('id',$data['event_id'])
			    			->update([
			    			'submited' => 0
			    			]);
		
		
		
		
        return redirect('home#collapse'.request('event_id').'#shift'.request('task_id'))
                        ->with('success','Shift created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
    	$attendee = Event::find($shift->event_id);
    	//dd($attendee);
    	$users = User::role($attendee->attendee)->get();
    	
        return view('shifts.edit',compact('shift','users'));
    }
	
	/**
     * Update the specified resource in storage.
     */
    public function massupdate(Request $request)
	{
	    //dd($request->all());
	    
	    $req = $request->validate([
	        'shift_id' => 'required',
	        'user_id' => 'required',
	        'task_id' => 'required',
	        'event_id' => 'required',
	    ]);
		
	    $tasks = Task::whereIn('id', $req['task_id'])->get();
	    $event = Event::findOrFail($req['event_id']);
	    $shifts = Shift::where('event_id', $req['event_id'])->pluck('user_id')->toArray();

		//retrieve user without jobs filtered by roles
	    $users_without_jobs = [];
	    foreach ($event->attendee as $attendee) 
	    {
	        $users = User::role($attendee)
	        		->where('email','!=',null)
	        		->get();
	        foreach ($users as $user) 
	        {
	            if (!in_array($user->id, $shifts)) 
	            {
	                $users_without_jobs[] = [
	                    'id' => $user->id,
	                    'email' => $user->email,
	                    'name' => $user->name,
	                    'firstname' => $user->firstname,
	                    'phone' => $user->phone,
	                    'phone_country' => $user->phone_country
	                ];
	            }
	        }
	    }
		
		
		
		
		
		//sending email to the queue
	    foreach ($users_without_jobs as $user) {
	        $key = Crypt::encryptString($user['phone']);
	        $urlToDashBoard = route('appredirect', ['key' => $key]);
	        $urlToDashBoard .= '#collapse'.$event->id;
			//dd($urlToDashBoard);
			
			
			
			
	        dispatch(new SendShifts($user, $event, $urlToDashBoard))
	            ->delay(now()->addSeconds(3));
	            
		    //sending sms  
		    if($request->has('SMS'))
		    {
		       //$phone = substr_replace($user['phone'], '32', 0, 1);
		       $phone = new PhoneNumber($user['phone'],$user['phone_country']);
		       $phone = $phone->formatE164(); 
		       // dd($phone);
		        $shortURLObject = ShortURL::destinationUrl($urlToDashBoard)->make();
				$shortURL = $shortURLObject->default_short_url;
				$text = 'Bonjour '.$user['firstname'].', La Fraternité souhaite faire appel à ton aide! Voici le détail des activités:'.$shortURL;
		        
		        $sms = new SMSController($phone,$text);
		        $sms->sendSmsNotification();
		        /*
		        $basic  = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
			    $client = new Client($basic);
			        $response = $client->sms()->send(
						    new \Vonage\SMS\Message\SMS($phone, env('VONAGE_FROM'), $text)
						);
		          */  
			}
	    }
		
		//updating shift statement
	    for ($i = 0; $i < count($req['shift_id']); $i++) {
	        $confirmed = ($req['user_id'][$i] == 0 || $req['user_id'][$i] == null) ? 0 : 1;

	        Shift::where('id', $req['shift_id'][$i])
	            ->update([
	                'user_id' => $req['user_id'][$i],
	                'is_sent' => 1,
	                'is_confirmed' => $confirmed,
	            ]);
	    }
		
		//updating event
	    Event::where('id', $req['event_id'])
	        ->update([
	            'submited' => 1
	        ]);

		
		
	    return redirect()->route('home')
	        ->with('success', 'Shift updated successfully');
	}


    

	 	/**
	     * Users subscribing shift.
	     */
	    public function update(Request $request, Shift $shift)
	    {
	    	
	    	
	  		$data =  $request->validate([
	          
	            'user_id' => 'required',
	            'start' => 'sometimes',
            	'end' => 'sometimes',
	            
	        ]);
	  		//dd($data);     
	        $shift->update($data + [
	        		
		            'is_confirmed' => 1,
	       
	        		]);
	      
	    
	    	//ical
	    	$ical =  $this->iCal($shift);
	        		
	  
	      		$subject = 'Horaire bénévole';
	      		//$file = Storage::disk('local')->get(env('APP_NAME').'.ics');
	      		//dd($file);
	    		Mail::to($shift->user->email)
	    			->cc(config('mail.from.address'))	
	    			->send(new UserShift($shift,$subject,$ical));
			
	        
	        return redirect()->route('home')
	                        ->with('success','Shift updated successfully');
	    }

		
		/**
	     * Admin updating shift.
	     */
	    public function updateShift(Request $request, Shift $shift)
	    {
	  	
	       $data =  $request->validate([
	          'start' => 'required',
              'end' => 'required',
              'user_id' => 'nullable',
	         ]);
	  		
	  		if($data['user_id'] != 0)
	  		{
	  			$confirmed = 1;
	  		}
	  		else {
	  			$confirmed = 0;
	  		}
	  		
	  		
	        $shift->update($data + [
	        'is_confirmed' => $confirmed,
	        
	        ]);
	        if($shift->user_id != 0 && $request->has('checkbox') )
	        {
	        
	        $ical =  $this->iCal($shift);	
	        $subject = 'Horaire bénévole';
	    		Mail::to($shift->user->email)
	    			->cc(config('mail.from.address'))	
	    			->send(new UserShift($shift,$subject,$ical));
	        
			}
	     	
	       return redirect('home#collapse'.$shift->event_id.'#shift'.$shift->task_id)
	                        ->with('success','Shift updated successfully');
	    }

		
		
		

	    /**
	     * Remove the specified resource from storage.
	     */
	    public function destroy(Shift $shift)
	    {
	    	
	        $shift->delete();
	        return redirect()->route('home')
	                        ->with('success','Shift deleted successfully');
	    }
	    
	    
	    public function iCal($shift) {
	    	//Generating Ical
			$vEvents = ICALEvent::create()
	    		->name($shift->task->name)
	    		->address('rue de la Fohalle 1, 4970 Francorchamps, Belgium')
	    		->description($shift->task->description ?? '')
	    		->startsAt(new DateTime($shift->event->start.''.$shift->start))
	    		->endsAt(new DateTime($shift->event->start.''.$shift->end))
	    		->organizer(config('mail.from.address'), config('app.name'))
	    		->image('https://events.sallelafraternite.be/img/fraternite.svg', 'text/svg+xml', Display::badge())
	    		//->attendee($shift->user->email, $shift->user->firstname.' '.$shift->user->name) // only an email address is required
	    		;
	    	
	    	// Récupérer les participants de la base de données
		    $attendees = Shift::where('task_id',$shift->task->id)
		    					->whereNotNull('user_id')
		    					->where('user_id','!=',0)
		    					->get(); // Modifiez la condition selon vos besoins
			
		    // Ajouter les participants à l'événement iCal
		    foreach ($attendees as $attendee) {
		        $vEvents->attendee($attendee->user->email ?? '', $attendee->user->firstname ?? '');
		    }
		    	
	    	
			$cal = Calendar::create(config('app.name'))
					->event($vEvents)
					->withoutTimezone()
					->get();
			
			
			
			// Save iCal to a file
		    
		   // Save iCal to a file
		    $filename = config('app.name') . '.ics';
		   // $filePath = storage_path($fileName);
		   $file = Storage::disk('local')->put($filename, $cal);

		    return Storage::disk('local')->path($filename);
	    	
	    	
	    }
	    
	    
}
