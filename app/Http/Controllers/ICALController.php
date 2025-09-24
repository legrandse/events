<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event as ICALEvent;
use DateTime;
use Carbon\Carbon;

class ICALController extends Controller
{
    
    //public $event;
	//public $task;
	public $shift;
	
     public function __construct($shift)
    {
    //	$this->event = $event;
    //	$this->task = $task;
    	$this->shift = $shift;
    	
    }
    
    
    public function calendar()
    {
    	
    	
    	$vEvents = ICALEvent::create($this->shift->task->name)
    		->startsAt(new DateTime($this->shift->event->start.''.$this->shift->start))
    		->endsAt(new DateTime($this->shift->event->start.''.$this->shift->end));
    	
		
		//dd($vEvents);
		Calendar::create(config('app.name'))
		->event($vEvents)->get();
		
		
    }
}
