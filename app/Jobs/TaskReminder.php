<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ShiftReminder;
use App\Models\User;
use Mail;

class TaskReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	protected $user;
	protected $event;
	protected $shifts;
	protected $url;
	
    /**
     * Create a new job instance.
     */
    public function __construct($user,$event,$shifts,$url)
    {
       $this->user = $user;
       $this->event = $event;   
       $this->shifts = $shifts; 
       $this->url  = $url;
      
    }
	
    /**
     * Execute the job.
     */
    public function handle(): void
    {
    	
        Mail::to($this->user['email'])->send(new ShiftReminder($this->user, $this->event, $this->shifts, $this->url));
    }
}
