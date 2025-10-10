<div>
	
	
	
	
	
	<form wire:submit.prevent="register">   
		@if($currentStep == 1)
				<div class="px-4 py-2 d-grid gap-2">
			       <a class="btn btn-danger"href="{{ route('auth.google') }}">
						<i class="fab fa-google"></i> Se connecter avec Google
					</a>
					<span>En cliquant sur "Se connecter avec Google", j'accepte les Conditions d'utilisation et la Politique de Confidentialité de Yoopi.</span>
				</div>
				<hr>
				<div class="row px-4 py-2">
	             	<div class="col-md-12">
	                     <div class="form-group mb-3">
	                         <label for="">{{__('Email')}}</label>
	                         <input type="email" class="form-control @error('email') is-invalid @enderror" autofocus placeholder="{{__('Enter email address')}}" wire:model.blur="email">
	                         <span class="text-danger">@error('email'){{ $message }}@enderror</span>
	                     </div>
	                 </div>
	                 <div class="col-md-12">
	                     <div class="form-group mb-3">
	                         <label for="">{{__('Password')}}</label>
	                         <input type="password" class="form-control @error('password') is-invalid @enderror" autofocus placeholder="{{__('Enter password')}}"  wire:model.blur="password">
	                        <span class="text-danger">@error('password'){{ $message }}@enderror</span>
	                     </div>
	                 </div>
	                 <div class="col-md-12">
	                     <div class="form-group mb-3">
	                         <input type="checkbox" class="form-check @error('terms') is-invalid @enderror" wire:model.terms="terms">
	                         <label for="">{{__('Terms of use')}}</label>
	                        <span class="text-danger">@error('terms'){{ $message }}@enderror</span>
	                     </div>
	                 </div>
	                 
	             </div>
		@endif
		
		@if ($currentStep == 2 )
	             <div class="row px-4 py-2">
	             	<h2>Help us personalize your experience </h2>
	                 <div class="col-md-6">
	                     <div class="form-group  mb-3">
	                         <label for="">{{__('Firstname')}}</label>
	                         <input type="text" class="form-control @error('firstname') is-invalid @enderror" placeholder="{{__('Enter first name')}}" wire:model.blur="firstname">
	                        <span class="text-danger">@error('firstname'){{ $message }}@enderror</span>
	                     </div>
	                 </div>
	                 <div class="col-md-6">
	                    <div class="form-group  mb-3">
	                        <label for="">{{__('Name')}}</label>
	                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('Enter last name')}}" wire:model.blur="name">
	                        <span class="text-danger">@error('name'){{ $message }}@enderror</span>
	                    </div>
	                </div>
	            
	             	<div class="form-group row  ">
	             	<label for="">{{__('Phone')}}</label>
		             	<div class="col-md-4">
		             	
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
	                 
	                 <div class="col-md-8">
	                    <div class="form-group row">
	                        
	                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" placeholder="{{__('Enter your phone 0412 34 56 78')}}" wire:model="phone">
	                        
	                        
	                        <span class="text-danger">@error('phone'){{ $message }}@enderror</span>
	                    </div>
	                   
	                </div>
	                </div>
		                     
	            </div>
	             
	     @endif
	     
	     @if ($currentStep == 3 )
	     	<div class="row px-4 py-2">
	             	<h2>Données de votre organisation </h2>
	                 <div class="col-md-6">
	                     <div class="form-group  mb-3">
	                         <label for="">{{__('Organisation')}}</label>
	                         <input type="text" class="form-control @error('organisation') is-invalid @enderror" placeholder="{{__('Enter company/organisation name')}}" wire:model.blur="organisation">
	                        <span class="text-danger">@error('firstname'){{ $message }}@enderror</span>
	                     </div>
	                 </div>
	                 <div class="col-md-6">
	                    <div class="form-group  mb-3">
	                        <label for="">{{__('Address')}}</label>
	                        <input type="text" class="form-control @error('address') is-invalid @enderror" placeholder="{{__('Enter company address')}}" wire:model.blur="address">
	                        <span class="text-danger">@error('address'){{ $message }}@enderror</span>
	                    </div>
	                </div>
	                <div class="col-md-6">
	                    <div class="form-group  mb-3">
	                        <label for="">{{__('Postcode')}}</label>
	                        <input type="text" class="form-control @error('postcode') is-invalid @enderror" placeholder="{{__('Enter company postcode')}}" wire:model.blur="postcode">
	                        <span class="text-danger">@error('postcode'){{ $message }}@enderror</span>
	                    </div>
	                </div>
	                <div class="col-md-6">
	                    <div class="form-group  mb-3">
	                        <label for="">{{__('Place')}}</label>
	                        <input type="text" class="form-control @error('place') is-invalid @enderror" placeholder="{{__('Enter company place')}}" wire:model.blur="place">
	                        <span class="text-danger">@error('place'){{ $message }}@enderror</span>
	                    </div>
	                </div>
	            	<div class="col-md-6">
	                    <div class="form-group  mb-3">
	                        <label for="">{{__('VAT')}}</label>
	                        <input type="text" class="form-control @error('vat') is-invalid @enderror" placeholder="{{__('Enter company VAT')}}" wire:model.blur="vat">
	                        <span class="text-danger">@error('vat'){{ $message }}@enderror</span>
	                    </div>
	                </div>
	             	
	                
		                     
	            </div>
     	
	     
	     @endif
	     
	     
	     
	     @if ($currentStep == 4 )
	     	<div class="row px-4 py-2">
             	<div class="col-md-12">
                     <div class="form-group mb-3">
                         <label for="">{{__('Plan')}}</label>
                         <select wire:model="plan" class="form-select">
					        <option value="">{{ __('Select Product') }}</option>
					        @foreach($prices as $price)
					       
					            <option value="{{ $price->id }}">
					                {{ $price->product }} - {{ $price->amount }}
					            </option>
					        @endforeach
					    </select>
                         
                     </div>
                 </div>
                 
                 
             </div>
     	
	     
	     @endif
	     
	     
	    @if ($currentStep == 1)
	        <div class="px-4 py-2 mb-3 d-grid gap-2 ">
	        	<button type="button" class="btn btn-primary " wire:click.prevent="next">{{__('Register')}}</button>
	        </div>
	    @endif 
	    
	    <div class="px-4 py-2 mb-3 action-buttons d-flex justify-content-between bg-white pt-2 pb-2">
			@if ($currentStep == 2 || $currentStep == 3 || $currentStep == 4 )
	            <button type="button" class="btn btn-secondary" wire:click.prevent="previous">{{__('Back')}}</button>
	        @endif
	        
	        @if ( $currentStep == 2 || $currentStep == 3 )
	            <button type="button" class="btn btn-primary" wire:click.prevent="next">{{__('Next')}}</button>
	        @endif
	        
	        @if ($currentStep == 4 )
	             <button type="submit" class="btn btn-primary">{{__('Send')}}</button>
	        @endif
	                
	    </div>
	
    </form>	
    
@script
<script>
	$wire.on('registered', () => {
        window.location.href = 'http://app.events.test';
    });
</script>
@endscript
	
	 
</div>
