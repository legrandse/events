<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\Task;
class Tasks extends Component
{
    public $tasks;
    public $event;
    public $name;
    public $event_id;
    public $description;
    public $showForm = true;
    
    public function showNewTask() {
    	
		$this->showForm = !$this->showForm;
		
    	
    }
    public function mount(){
    	$this->event = Event::find($this->event_id);
    	$this->tasks = Task::where('event_id',$this->event_id)->get();
    	
    }
    
   
    public function save() {
    	$data = $this->validate([
               
            'name' => 'required',
            'event_id' => 'required',
            'description'=> 'sometimes',
        ]);
    
        Task::create($data);
    	$this->dispatch('close-modal'); 
     	session()->flash('message', 'Post successfully updated.');
     	
     	return $this->redirect('/home#extend'.$this->event_id);
     	
       // session()->flash('success','Task created successfully.');
        
       // return redirect('/home');
    	// $this->showForm = false;   
    	// $this->dispatch('refresh');
    	
        
    }
    
    
    
    
    
    public function render()
    {
    	//$event = Event::find($this->event_id);
    	//$tasks = Task::where('event_id',$this->event_id)->get();
        return view('livewire.tasks');
    }
}
