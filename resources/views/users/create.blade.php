@extends('layouts.app')


@section('content')
<div class="container">
	<div class="row">

	    <div class="col-lg-12 margin-tb">

	        

	        <div class="pull-right">

	            <a class="btn btn-secondary" href="{{ route('users.index') }}"> {{__('Back')}}</a>

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
				<h2>{{__('Create New User')}}</h2>
				</div>
			
			<div class="card-body">	
				<form action="{{ route('users.store') }}" method="post">
				@method('POST')
				@csrf


				<div class="row">
					
					<div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group">

				            <strong>{{__('Single record')}}:</strong>

				            <input type="checkbox" class="form-check-input" name="single" id="checkbox" value="1" />

				        </div>

				    </div>
					
				    <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group">

				            <strong>{{__('Name')}}:</strong>

				            <input type="text" class="form-control" name="name" value="{{old('name')}}" />

				        </div>

				    </div>
				    
				    <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group mb-3">

				            <strong>{{__('Firstname')}}:</strong>
							
				            <input type="text" class="form-control" name="firstname" value="{{old('firstname')}}" />

				        </div>

				    </div>
				    
				    <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group row ">

				            <strong>{{__('Phone')}}:</strong>
				            <!--<div class="input-group mb-3 ">
					            <div class="input-group-text">
									<input type="checkbox" class="form-check-input mt-0" name="single" id="checkbox" value="1" />
								</div>
							-->
							
				            	<input type="text" class="form-control " name="phone" value="{{old('phone')}}"/>
							</div>

				        </div>

				    </div>

				    <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group autoHidden">

				            <strong>{{__('Email')}}:</strong>

				            <input type="email" class="form-control " name="email" value="{{old('email')}}" />

				        </div>

				    </div>

				    <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group autoHidden">

				            <strong>{{__('Password')}}:</strong>

				            <input type="password" class="form-control " name="password" value="{{old('password')}}" />

				        </div>

				    </div>

				    <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group autoHidden">

				            <strong>{{__('Confirm Password')}}:</strong>

				            <input type="password" class="form-control " name="confirm-password" />

				        </div>

				    </div>

				     <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group ">

				            <strong>{{__('Role')}}:</strong>
							<select class="form-select " multiple aria-label="role" id="role" name="roles[]" >
							@foreach($roles as $role)
							    <option  value="{{$role}}" {{ (old('roles') && in_array($role, old('roles'))) ? 'selected' : '' }} >{{ $role }}  </option>
							@endforeach
							</select>
							
						</div>

				    </div>
					<div class="card-body">
				    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
						<div class="form-group">
				        	<button type="submit" class="btn btn-primary">{{__('Save')}}</button>
						</div>
				    </div>

					</div>
				</div>
				</form>
				
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#checkbox').change(function(){
	if(!this.checked)
	$('.autoHidden').fadeIn('slow');
	else
	$('.autoHidden').fadeOut('slow');

});
});
</script>
@endsection