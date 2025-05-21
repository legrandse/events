<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use App\Models\Settings;
use App\Models\Event;
use App\Models\Task;
use App\Models\Shift;

class ControlPanel extends Component
{
	use WithFileUploads;
	
	#[Rule('image|max:1024')] // 1MB Max
    public $photo;
	
	public $archiveToggle ;
	public $archiveValue;
	
	public $events;
	public $event_id;
	
	
	public function mount() {
		$this->archiveToggle = Settings::find(2)->value;
        $this->archiveValue = Settings::find(1)->value;
		
		$this->events = Event::all();
	}
	
	
	
	public function archiveButton()
	{
		 $this->archiveToggle = !$this->archiveToggle;
        Settings::find(2)->update(['value' => $this->archiveToggle]);
		$this->archiveValue = !$this->archiveToggle ? 0 : $this->archiveValue;
				
	}
	
	public function validateData(){

            $this->validate([
                'archiveValue' => 'required',
            ]);
        }
	
	
	public function saveArchiveValue() {
		$this->validateData();
		
		$settings = Settings::find(1);
        $settings->value = $this->archiveToggle ? $this->archiveValue : 0;
        $settings->save();
			
		session()->flash('success', 'Operation success.');
		
		
	}
	
	public function resetEvent()
	{
		$shift = Shift::where('event_id',$this->event_id)
				->update([
				'user_id' => null,
				'is_confirmed'=>0
				]);
				
		session()->flash('success', 'Event reset.');
				
	}
	
	/*public function duplicateEvent($eventId)
	{
	    // Récupérer l'événement original
    $originalEvent = Event::find($eventId);
	
    if (!$originalEvent) {
        return response()->json(['message' => 'Event not found'], 404);
    }

    // Créer une nouvelle instance de l'événement
    $newEvent = new Event();
    $newEvent->name = $originalEvent->name;
    $newEvent->attendee = $originalEvent->attendee;
    $newEvent->location = $originalEvent->location;
    $newEvent->start = now();
    
    $newEvent->created_at = now();
    $newEvent->updated_at = now();

    // Enregistrer la copie dans la base de données
    $newEvent->save();

    // Récupérer les tâches de l'événement original
    $originalTasks = Task::where('event_id', $eventId)->get();

    // Dupliquer chaque tâche
    foreach ($originalTasks as $task) {
        $newTask = new Task();
        $newTask->event_id = $newEvent->id;
        $newTask->name = $task->name;
        $newTask->description = $task->description;
        $newTask->created_at = now();
        $newTask->updated_at = now();
        $newTask->save();
    
	
    // Récupérer les quarts de travail de l'événement original
    $originalShifts = Shift::where('task_id', $task->id)->get();

    // Dupliquer chaque quart de travail
    foreach ($originalShifts as $shift) {
        $newShift = new Shift();
        $newShift->event_id = $newEvent->id;
        $newShift->task_id = $newTask->id;
        $newShift->start = $shift->start;
        $newShift->end = $shift->end;
        $newShift->created_at = now();
        $newShift->updated_at = now();
        $newShift->save();
    }
	}
    session()->flash('success', 'Event duplicated.');
    
}*/
public function duplicateEvent($eventId)
	{
	    $originalEvent = Event::with('tasks.shifts')->findOrFail($eventId);
	   // dd($originalEvent);
	    
	    // Récupérer l'événement original
	   /* $originalEvent = Event::find($eventId);
	    $originalTasks = Task::where('event_id',$eventId)->get();
	    $originalShifts = Shift::where('event_id',$eventId)->get();
		
		*/
		//dd($originalEvent);
		
	    

	    // Créer une copie de l'événement
	    $newEvent = $originalEvent->replicate();
	    
	    // Modifier les attributs nécessaires pour éviter les conflits (comme les identifiants uniques)
	    //$newEvent->name = $originalEvent->name;
	    $newEvent->start = now();
	   // $newEvent->created_at = now();
	    //$newEvent->updated_at = now();

	    // Enregistrer la copie dans la base de données
	    $newEvent->save();
	    
	   // Dupliquer les tâches et les shifts
        foreach ($originalEvent->tasks as $originalTask) {
            // Dupliquer la tâche
            $newTask = $originalTask->replicate();
            $newTask->event_id = $newEvent->id;
            $newTask->save();

            // Dupliquer les shifts
            foreach ($originalTask->shifts as $originalShift) {
                $newShift = $originalShift->replicate();
                $newShift->event_id = $newEvent->id;
                $newShift->task_id = $newTask->id;
                $newShift->user_id = null;
                $newShift->is_confirmed = 0;
                $newShift->save();
            }
        }
	    session()->flash('success', 'Event reset.');
	}
	
	
	
	//store image
	    public function save()
    {
        $this->photo->storeAs('public/logo/logo.jpg');
        $this->redirect('/settings'); 
        
		session()->flash('success', 'Success.');
    }
	
	
    public function render()
    {
    	$array = ["0"=>"Open this select menu","5"=>"05","10"=>"10","20"=>"20","30"=>"30"];
    	
        return view('livewire.control-panel',compact('array'));
    }
}
