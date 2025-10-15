<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Owner;
use App\Models\OwnerUser;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;


class SearchUser extends Component
{
	use WithPagination;
	
	protected $paginationTheme = 'bootstrap';
	//public User $user_id;
	public $search = '' ;
	public $showModal = '';

 	
    
    /**
	* /
	* When using paginate
	* @return
	*/
	public function updatingSearch()

    {

        $this->resetPage();

    }

 	public function showModals($id){
    	$this->showModal = $id;
    	
    	
    	}
    	
    public function delete(){
    	User::find($this->showModal)->delete();
    	//For hide modal after add task success
        
    	
    	
    	}
    

    public function render()

    {
    	 	
    	       
        
        $usersByOwner = Owner::find($owner->id);
        				
		$users = $usersByOwner->users()
			    ->where(function ($query) {
			        $query->where('name', 'like', '%' . $this->search . '%')
			              ->orWhere('firstname', 'like', '%' . $this->search . '%');
			    })
			    ->paginate(10);
			    
		
					
        return view('livewire.search-user',compact('users'));

    }
    
    
   
    
    
    
        
}
