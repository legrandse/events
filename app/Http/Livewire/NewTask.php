<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NewTask extends Component
{
	public $name;
	public $event_id;
	public $description;
	
	protected $rules = [
            'name' => 'required',
            'event_id' => 'required',
            'description'=> 'sometimes',
        ];
        
    public function submit()
    {
        $this->validate();
        Task::create([
        	'name'=> $this->name,
        	'event_id' => $this->event_id,
        	'description'=> $this->description,
        ]);
        
       session()->flash('message', 'Task created successfully.');
    }
}
