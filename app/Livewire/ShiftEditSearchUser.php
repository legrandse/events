<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Event;
use App\Models\User;
use App\Models\Shift;

use Spatie\Permission\Traits\HasRoles;

class ShiftEditSearchUser extends Component
{
	
	//use HasRoles;
	//protected $paginationTheme = 'bootstrap';
   // public User $user_id;
    public $search ;
	public $userSelected = '';
	public $shift;
	
	
	
	public function mount(){
		
		
		$this->userSelected = $this->shift->user_id ;
		
	}
	
	
    public function render()
    {
    	$attendee = Event::find($this->shift->event_id);
    	//dd($attendee->attendee);
    	$users = User::where('name','like', '%'.$this->search.'%')
					->orWhere('firstname', 'like', '%'.$this->search.'%')
					->role($attendee->attendee)
    				->get();
    	//dd($users);
    	/*$users = User::where('name','like', '%'.$this->search.'%')
					->orWhere('firstname', 'like', '%'.$this->search.'%')
					->get();*/
    	
        return view('livewire.shift-edit-search-user', compact('users'));
    }
}
