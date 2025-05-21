<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Shift;
use App\Models\Event;
class ChangeUser extends Component
{
	public $user_id;
	public $shifts = [];	

	public function submit(Shift $shift)
    {
    	$this->shift = $shift;
        $data = $this->validate([
     //       'start' => 'required',
       //     'end' => 'required',
            'user_id' => 'required',
        ]);
   	dd($data);
   	
        Shift::save($data);
   
        return redirect()->route('home');
    }

	


    public function render()
    {
    	
        return view('livewire.change-user', [
        'users' => User::all(),
       'shifts' => Shift::all(),
        
        ]);
    }


	    /**

     * Write code on Method

     *

     * @return response()

     */

    public function changeEvent($value)

    {

        $this->user_id = $value;
	}

}
