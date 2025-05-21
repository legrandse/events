@extends('layouts.app')


@section('content')
<div class="container">
	<div class="row">

	    <div class="col-lg-12 margin-tb">

	        <div class="pull-right">

	            <a class="btn btn-secondary" href="@unlessrole('Admin'){{  route('home') }}@else {{  route('users.index') }} @endunlessrole"> {{__('Back')}}</a>

	        </div>

	    </div>

	</div>


@if (count($errors) > 0)

  <div class="alert alert-danger">

    <strong>Whoops!</strong> There were some problems with your input.<br><br>

    <ul>

       @foreach ($errors->all() as $error)

         <li>{{ $error }}</li>

       @endforeach

    </ul>

  </div>

@endif
<div class="col-sm-12">		
			<div class="card">
				<div class="card-header bg-light py-3 d-flex flex-row align-items-center justify-content-between">
				<h2>{{__('Edit User')}}</h2>
				</div>
			<form action="{{ route('users.update',['user'=>$user->id]) }}" method="post">
				@method('patch')
				@csrf
			<div class="card-body">	
				
				<div class="row">

				    <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group">

				            <strong>{{__('Name')}}:</strong>
							<input type="text" class="form-control" name="name" value="{{ old('name',$user->name) }}" />
				           <input type="hidden" class="form-control" name="social" value="{{ old('social',$user->social_id) }}" />

				        </div>

				    </div>
				  @if(!$user->social_id )  
				    <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group">

				            <strong>{{__('Firstname')}}:</strong>
							<input type="text" class="form-control" name="firstname" value="{{ old('firstname', $user->firstname) }}" />
				           

				        </div>

				    </div>
				@endif
				    <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group">

				            <strong>{{__('Email')}}:</strong>
							<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" />
				            

				        </div>

				    </div>
				    
				    <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group">
				        <strong>{{__('Phone')}}:</strong>
							<select class="form-select @error('phone_country') is-invalid @enderror" name="phone_country">
									 <option disabled selected>{{__('Select country')}}</option>
									  @foreach($countries as $key=> $country)
									  <option value="{{$key}}" {{ old('phone_country', $user->phone_country)  == $key ? 'selected' : ''  }}>{{$country}}</option>
									  @endforeach
									</select>
							
							
									<span class="text-danger">@error('phone_country'){{ $message }}@enderror</span>
				            
							<input type="tel" class="form-control" name="phone" value="{{ old('phone', $phone) }}" placeholder="0412 34 56 78" />
				           

				        </div>

				    </div>
					@if(!$user->social_id )  
				    <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group">

				            <strong>{{__('Password')}}:</strong>
							<input type="password" class="form-control @error('msg') is-invalid @enderror" name="password" value="" />
				           

				        </div>
						
   						
				    </div>

				    <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group">

				            <strong>{{__('Confirm Password')}}:</strong>
							<input type="password" class="form-control" name="confirm-password" value="" />
				           

				        </div>

				    </div>
				    @endif
					@role('Admin') 
				        <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group">

				            <strong>{{__('Role')}}:</strong>
							<select class="form-select" multiple aria-label="role" id="role" name="roles[]"   >
							@foreach($roles as $key => $role)
							    <option  value="{{$role}}" {{ in_array($role, $userRole) ? 'selected' : '' }} >{{ $role }} </option>
							    
							@endforeach
							</select>
						</div>
						</div>
					@endrole
					
				            
				</div>
				</div>        

				  
				<div class="card-body">
				    <div class="col-xs-12 col-sm-12 col-md-12 text-center">

				        <button type="submit" class="btn btn-primary">{{__('Save')}}</button>

				    </div>

				</div>

				</form>
				
	</div>
</div>


@endsection