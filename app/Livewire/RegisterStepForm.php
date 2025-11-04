<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Hash;

use App\Mail\OwnerRegistered;

use App\Models\Product;
use App\Models\Owner;
use App\Models\OwnerUser;
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
    public $shortname;
    public $address;
    public $postcode;
    public $place;
    public $vat;
    
    
    public $plan;
    public $selectedPlan;
    //public $prices = [];
    
    public $password_confirmation;
    
    
    public function mount(){
    	
    	$this->prices = Product::all();
    	
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
                //'phone'=>'phone:mobile|unique:users',
                'phone'=>'phone:mobile',
            ]);
        }
        if($this->currentStep == 3){
              $this->validate([
                 'organisation' => 'required',
                 'shortname' => 'required|unique:owners,shortname',
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
	        'shortname'=> Str::slug($this->shortname, '-'),
	        'address' => $this->address,
	        'postcode' => $this->postcode,
	        'place' => $this->place,
	        'vat' => $this->vat,
	        'product_id' => $this->plan
	        
	    ];
		
		$owner = Owner::create($ownerValues);
	    
		
		$userValues = [
	        
	        'email' => $this->email,
	        'password' => Hash::make($this->password),
	        'firstname' => $this->firstname,
	        'name' => $this->name,
	        'phone_country' => $this->phone_country,
	        'phone' => str_replace(['.', '/', ' ', ','], '', $this->phone),
	        
	        
	    ];
	    
	    // 🔹 Étape 1 : récupérer le sous-domaine
	    $host = request()->getHost(); // ex: team1.monapp.com
	    $parts = explode('.', $host);
	    $subdomain = count($parts) > 2 ? $parts[0] : null;

	    // 🔹 Étape 2 : trouver l’owner associé
	   
	    if ($owner) {
	        setPermissionsTeamId($owner->id); //set current team according domain
	    }

	   else {
	        session()->flash('message', 'Sous-domaine invalide ou non associé à un propriétaire.');
	        return;
	    }
		
		//create user with role and team
		$roles = ['Admin', 'Comité', 'Bénévole'];

		foreach ($roles as $roleName) {
		    $role = Role::create(['name' => $roleName]);

		    if ($roleName === 'Comité') {
		        // Permissions de 5 à 20
		        $permissions = Permission::whereBetween('id', [5, 20])
		            ->pluck('id')
		            ->toArray();
		        $role->syncPermissions($permissions);
		    }

		    if ($roleName === 'Admin') {
		        // Toutes les permissions
		        $allPermissions = Permission::pluck('id')->toArray();
		        $role->syncPermissions($allPermissions);
		    }

		    if ($roleName === 'Bénévole') {
		        // Permissions spécifiques : 5, 9, 13, 15, 19
		        $permissions = Permission::whereIn('id', [5, 9, 13, 15, 19])
		            ->pluck('id')
		            ->toArray();
		        $role->syncPermissions($permissions);
		    }
		}
       	
       	//check if user exist
       	$existingUser = User::where('email',$userValues['email'])
       						->orWhere('phone',$userValues['phone'])
       						->first();
       	
       	$user = $existingUser ?? User::create($userValues);
		$user->assignRole('Admin');

		// Créer l’enregistrement dans la table pivot
		OwnerUser::create([
		    'owner_id' => $owner->id,
		    'user_id' => $user->id,
		]);

		// Envoyer le mail
		Mail::to($user->email)
		    //->cc(config('mail.from.address'))
		    ->send(new OwnerRegistered($owner));
	    	
	    
	    
	    
	    
	    
		//créer dossier Image
		Storage::makeDirectory('public/'.$owner->id);
		
		Auth::loginUsingId($user->id);
		// Régénère la session et le token CSRF
	    session()->regenerate();  // Cela va régénérer la session
	    session()->regenerateToken(); // Et créer un nouveau token CSRF
		
		session()->flash('status', 'User created successfully.');
 
        $this->dispatch('registered', url: 'http://'.$owner->shortname. '.' .parse_url(config('app.url'), PHP_URL_HOST));

		
		
			
	}
	
	
	
    public function render()
    {
    	$prices = Product::all();
        return view('livewire.register-step-form', compact('prices'));
    }
}
