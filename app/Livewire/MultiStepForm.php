<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Hash;
use Crypt;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewUserRegistration;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Propaganistas\LaravelPhone\PhoneNumber;

class MultiStepForm extends Component
{
	
	use RegistersUsers;
	
	
	public $phone_country;
    public $phone;
    public $remember = false;
    
    public $email;
	public $firstname;
    public $name;
       
    public $password;
    public $password_confirmation;
	
	public $showLogin = false;
	
    
    public $totalSteps = 3;
    public $currentStep = 1;
	
	
	
	
	public function mount(){
        $this->currentStep = 1;
    }


	
    public function render()
    {
        return view('livewire.multi-step-form');
    }
    
    
    public function increaseStep(){
        $this->resetErrorBag();
        $this->validateData();
         $this->currentStep++;
         if($this->currentStep > $this->totalSteps){
             $this->currentStep = $this->totalSteps;
         }
    }

    public function decreaseStep(){
        $this->resetErrorBag();
        $this->currentStep--;
        if($this->currentStep < 1){
            $this->currentStep = 1;
        }
    }

	/*
	 * Validate the registration data.
	 */


    public function validateData(){

        if($this->currentStep == 0){
            $this->validate([
               
               'phone' => 'required',
	            'password' => 'required',
                
            ]);
        }
        
        if($this->currentStep == 1){
            $this->validate([
                'phone_country'=>'required_with:phone',
                'phone'=>'phone:mobile|unique:users',
                
            ]);
        }
        elseif($this->currentStep == 2){
              $this->validate([
                 'email'=>'required|email',
                 'firstname'=>'required',
                 'name'=>'required',
                 
              ]);
        }
        
        
        
    }
	
	public function openLogin()
	{
		$this->currentStep = 0;
		$this->showLogin = !$this->showLogin;
		if(!$this->showLogin)
		{
			$this->currentStep = 1;
		}
		
	}
	
	
	
	
	public function login(){
		
        $this->currentStep = 0;
        $this->resetErrorBag();
        $this->validateData();
        //$house = House::find(1);
 		//$remember = request('remember');
 		
        //if (Auth::attempt($credentials, $remember)) {
        //		$request->session()->regenerate();
	    	
	        
	        if(Auth::attempt(array('phone' => $this->phone, 'password' => $this->password),$this->remember)){
	                //session()->flash('message', "You are Login successful.");
	                return $this->redirect('/home');
	        }else{
	            session()->flash('message', 'email and password are wrong.');
	            
	        }
	
	}
	
	/*
	 * Create a new user and assign the 'Bénévole' role.
	 *
	 * @return \App\Models\User
	 */
	
	private function createUser()
	{
	    $values = [
	        "firstname" => $this->firstname,
	        "name" => $this->name,
	        "email" => $this->email,
	        "phone_country" => $this->phone_country,
	        "phone" => str_replace(['.', '/', ' ', ','], '', $this->phone),
	        "password" => Hash::make($this->password)
	    ];
		$phone = new PhoneNumber($values['phone'], $values['phone_country']);
		$values['phone'] = $phone->formatForMobileDialingInCountry($values['phone_country']);
		
		
		
	    $user = User::create($values);
	    $user->assignRole('Bénévole');

	    return $user;
	}
	
	
	
	
	/*
	 * Send a registration email to the user.
	 *
	 * @param \App\Models\User $user
	 */
	
	
	private function sendRegistrationEmail($user)
	{
	    $key = Crypt::encryptString($user->phone);
	    $urlToDashboard = route('appredirect', ['key' => $key]);

	    Mail::to($user->email)
	        ->cc(config(mail.from.address))
	        ->send(new NewUserRegistration($user, $urlToDashboard));
	}
	
	
	
	
	
	
	/*
	 * Handle the registration process.
	 */
	
	public function register()
	{
	    $this->resetErrorBag();

	    if ($this->currentStep == 3) {
	        $this->validateData();

	        $user = $this->createUser();
	        Auth::loginUsingId($user->id);
	        $this->sendRegistrationEmail($user);

	        return $this->redirect('home');
	    }
	}
	
	
	
	
	
	/*
    public function register(){
          $this->resetErrorBag();
            if($this->currentStep == 3){
              $this->validate([
                  'password'=>'required|min:6|same:password_confirmation',
              ]);
          
              $values = array(
                  "firstname"=>$this->firstname,
                  "name"=>$this->name,
                  "email"=>$this->email,
                  //"phone"=>$this->prefix.str_replace(array('.', '/',' ',','), '', $this->phone),
                  "phone_country"=>$this->phone_country,
                  "phone"=>str_replace(array('.', '/',' ',','), '', $this->phone),
                  "password"=>Hash::make($this->password)
                  
              );

              $user = User::create($values)
              ->assignRole('Bénévole');
            
            Auth::loginUsingId($user->id);
            
            //used in the email link
            $key = Crypt::encryptString($user->phone);
			$urlToDashBoard = route('appredirect',['key'=>$key]);
            
             Mail::to($user->email)
				->cc(config(mail.from.address))        	
        		->send(new NewUserRegistration($user,$urlToDashBoard));
            
            
            return $this->redirect('home');
          }
    }
    */
    
    
    
}
