<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Spatie\Permission\Models\Role;


use Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Price;
use App\Models\Owner;
use App\Models\User;

class RegisterStepForm extends Component
{
	public $currentStep = 1;
 	public $totalSteps = 4;
 	
 	
 	public $email;
 	public $password;
 	public $terms = false; 
 	
	public $firstname;
	public $name;
    public $phone_country;
    public $phone;   
    
    public $organisation;
    public $address;
    public $postcode;
    public $place;
    public $vat;
    
    
    public $plan;
    public $selectedPlan;
    //public $prices = [];
    
    public $password_confirmation;
    
    
    public function mount(){
    	
    	$this->prices = Price::all();
    	
    	
    	
    }
    
    
    
 
    public function next(){
     
     $this->validateData(); 

       $this->currentStep++;
         if($this->currentStep > $this->totalSteps){
             $this->currentStep = $this->totalSteps;
         }
   
    }

    public function previous(){
        
        $this->currentStep--;
        if($this->currentStep < 1){
            $this->currentStep = 1;
        }
    }
   
   	#[On('setPlan')] 
	public function setPlan($data)
    {
    	
        $this->plan = $data;
    }   
    
    
    public function validateData(){

        if($this->currentStep == 1){
            $this->validate([
               
                'email' => 'required|email',
	            'password' => 'required|min:8|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
	            'terms' => 'accepted'
                
            ]);
        }
        
        if($this->currentStep == 2){
            $this->validate([
                'firstname'=>'required',
                'name'=>'required',
                'phone_country'=>'required_with:phone',
                'phone'=>'phone:mobile|unique:users',
                
            ]);
        }
        if($this->currentStep == 3){
              $this->validate([
                 'organisation' => 'required',
                 'address' => 'required',
                 'postcode' => 'required',
                 'place' => 'required',
                 'vat' => 'sometimes',
              ]);
        }
        if($this->currentStep == 4){
              $this->validate([
                 'selectedPlan' => 'required'
                 
              ]);
        }
	}
	
    /*
	 * Create a new user and assign the 'Bénévole' role.
	 *
	 * @return \App\Models\User
	 */
	
	public function register()
	{
	    
	    
	    $ownerValues = [
	        
	        'organisation' => $this->organisation,
	        'address' => $this->address,
	        'postcode' => $this->postcode,
	        'place' => $this->place,
	        'vat' => $this->vat,
	        'product_id' => $this->plan
	        
	    ];
		
		$owner = Owner::create($ownerValues);
	    $slug = Str::slug($owner->organisation, '-');
		
		$userValues = [
	        
	        'email' => $this->email,
	        'password' => Hash::make($this->password),
	        'firstname' => $this->firstname,
	        'name' => $this->name,
	        'phone_country' => $this->phone_country,
	        'phone' => str_replace(['.', '/', ' ', ','], '', $this->phone),
	        'owner_id' => $owner->id,
	        
	    ];
		
		
	    $user = User::create($userValues);
	    $user->assignRole('Admin');
		
		session()->flash('status', 'Post successfully updated.');
 
        $this->dispatch('registered', url: 'http://'.$slug.'.events.test');

		Auth::loginUsingId($user->id);		
	}
	
	
	
    public function render()
    {
    	$prices = Price::all();
        return view('livewire.register-step-form', compact('prices'));
    }
}
