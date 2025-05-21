<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ShiftSent;
use Mail;
use App\Models\User;
use App\Models\Shift;
use App\Models\Event;

class SendShifts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $events;
	protected $user;
	protected $url;

    /**
     * Create a new job instance.
     */
    public function __construct($user,$events,$url)
    {
       
       $this->user = $user;   
       $this->events = $events; 
       $this->url  = $url;
       
     	
 	}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
    	
        Mail::to($this->user['email'])->send(new ShiftSent($this->user, $this->events, $this->url));
    }
}
