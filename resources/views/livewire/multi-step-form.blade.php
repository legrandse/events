<div>
    
     
		{{-- STEP 0 --}}

         
	         @if ($showLogin && $currentStep == 0 )
	         	
	            
	         
	        	<div>
					 @if (session()->has('message'))
		            	<div class="alert alert-danger">
	                		{{ session('message') }}
	            		</div>
			         @endif
	    		</div>
	    		
	    		
	         	<form id="login" wire:submit.prevent="login">    
	                     <div class="row px-4 py-2">
	                         	<label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>
	                            <div class="col-md-6">
	                                	<input type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="{{__('Enter phone number')}}" wire:model="phone">
	                                	<span class="text-danger">@error('phone'){{ $message }}@enderror</span>
	                            </div>
	                     </div>
	                     <div class="row px-4 py-2">
	                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

	                            <div class="col-md-6">
	                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{__('Enter password')}}"  wire:model="password">
									<span class="text-danger">@error('password'){{ $message }}@enderror</span>
	                        	</div>
	                    </div>
	                    <div class="row px-4 py-2">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row px-4 py-2">
                            <div class="col-md-6 offset-md-4">
		                    @if (Route::has('password.request'))
	                                    <a class="btn btn-link" href="{{ route('password.request') }}">
	                                        {{ __('Forgot Your Password?') }}
	                                    </a>
	                        @endif
	                    	</div>
	                    </div>
	                    
		               
		               <div class="px-4 py-2 mb-3 d-grid gap-2 ">
		                 <button type="submit" id="log" class="btn btn-primary">{{__('Send')}}</button>
		               </div>  
	          </form>
	           
	        @endif    
		 <form id="register" wire:submit.prevent="register">   
         
         

         {{-- STEP 1 --}}


			
		         @if ($currentStep == 1 && !$showLogin)
		             
		        
		         
		                     <div class="row px-4 py-2">
		                     	<div class="col-md-12">
		                         	<select class="form-select @error('phone_country') is-invalid @enderror" wire:model="phone_country">
									  <option selected>{{__('Select country')}}</option>
									  <option value="BE">Belgique (+32)</option>
									  <option value="LU">Luxembourg (+352)</option>
									  <option value="NL">Pays-Bas (+31)</option>
									  <option value="FR">France (+33)</option>
									  <option value="DE">Allemagne (+49)</option>
									</select>
									<span class="text-danger">@error('phone_country'){{ $message }}@enderror</span>
									 
		                         </div>
		                         
		                         <div class="col-md-12">
		                            <div class="form-group">
		                                
		                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" placeholder="{{__('Enter your phone 0412 34 56 78')}}" wire:model="phone">
		                                
		                                
		                                <span class="text-danger">@error('phone'){{ $message }}@enderror</span>
		                            </div>
		                           
		                        </div>
		                     </div>
		                     
		                

		         @endif
			
			
			
         {{-- STEP 2 --}}

         @if ($currentStep == 2 )
             
     
         
                     <div class="row px-4 py-2 mb-3">
                     	<div class="col-md-12">
                             <div class="form-group">
                                 <label for="">{{__('Email')}}</label>
                                 <input type="email" class="form-control @error('email') is-invalid @enderror" autofocus placeholder="{{__('Enter email address')}}" wire:model="email">
                                 <span class="text-danger">@error('email'){{ $message }}@enderror</span>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="">{{__('Firstname')}}</label>
                                 <input type="text" class="form-control @error('firstname') is-invalid @enderror" placeholder="{{__('Enter first name')}}" wire:model="firstname">
                                <span class="text-danger">@error('firstname'){{ $message }}@enderror</span>
                             </div>
                         </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="">{{__('Name')}}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('Enter last name')}}" wire:model="name">
                                <span class="text-danger">@error('name'){{ $message }}@enderror</span>
                            </div>
                        </div>
                     </div>
                     
                 
             
         @endif

         {{-- STEP 3 --}}

         @if ($currentStep == 3)
             
     
         
                     
                     <div class="row px-4 py-2 mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" autofocus placeholder="{{__('Enter password')}}"  wire:model="password">
							<span class="text-danger">@error('password'){{ $message }}@enderror</span>
                        	</div>
                    </div>

                        <div class="row mb-3" >
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control" placeholder="{{__('Confirm password')}}" wire:model="password_confirmation" >
                            </div>
                        </div>
                     
                
                     
                     
                     
               
             
         @endif
       
         	@if ($currentStep == 1 && $showLogin == false)
                <div class="px-4 py-2 mb-3 d-grid gap-2 ">
                <button type="button" class="btn btn-primary " wire:click.prevent="increaseStep">{{__('Register')}}</button>
                </div>
            @endif

         <div class="px-4 py-2 mb-3 action-buttons d-flex justify-content-between bg-white pt-2 pb-2">

           

            @if ($currentStep == 2 || $currentStep == 3 )
                <button type="button" class="btn btn-secondary" wire:click.prevent="decreaseStep">{{__('Back')}}</button>
            @endif
            
            @if ( $currentStep == 2 )
                <button type="button" class="btn btn-primary" wire:click.prevent="increaseStep">{{__('Next')}}</button>
            @endif
            
            @if ($currentStep == 3 )
                 <button type="submit" id="reg" class="btn btn-primary">{{__('Send')}}</button>
            @endif
                
               
         </div>
         
         
     </form>
     <div class="mx-auto" wire:loading.delay.longer wire:target="register">

        		<img src="{{ asset('img/loading.gif') }}" width="10%"  />
		</div>	
     <p class="text-center">
		      _______________	 ou    ________________
	 </p>
		    
		      		<div class="px-4 py-2 d-grid gap-2">
                    	<a class=" btn btn-primary" href="{{ url('redirect') }}" >
			            	<i class="fab fa-facebook-square"></i> Se connecter avec Facebook
			            </a>
			        </div>
			        <div class="px-4 py-2 d-grid gap-2">
                       <a class="btn btn-danger"href="{{ route('auth.google') }}">
							<i class="fab fa-google"></i> Se connecter avec Google
						</a>
					</div>
					<div class="px-4 py-2 mb-3 d-grid gap-2">
                         <button type="button" class="btn btn-warning" wire:click.prevent="openLogin">
                            @if ($currentStep == 1 && $showLogin == false)
                            <i class="icon-fraternite"></i>{{  __(' Se connecter avec La Fraternité') }}
                            @else {{__('Back')}}
                            @endif
                          </button>
					</div>


</div>
