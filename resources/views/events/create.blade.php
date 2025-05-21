@extends('layouts.app')
@section('content')
<div class="container">
    
		    @if ($errors->any())
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
		    <h2>{{__('Add event')}}</h2>
		    </div>
		    
		   <form action="{{ route('events.store') }}" id="eventconfirm" method="POST">
			@method('POST')
			@csrf
		    <div class="card-body">
		    
		        
		         
			         <div class="row">
			            <div class="col-xs-12 col-sm-12 col-md-12">
			                <div class="form-group @error('name') is-invalid @enderror">
			                    <strong>{{ __('Name') }}:</strong>
			                    <input type="text" name="name" class="form-control text-capitalize" placeholder="{{__('Name')}}" value="{{old('name')}}">
			                </div>
			                @error('name')
							<div class="invalid-feedback">{{ $errors->first('name') }}</div>
							@enderror
			            </div>
			            <div class="col-xs-12 col-sm-12 col-md-12">
			                <div class="form-group @error('start') is-invalid @enderror">
			                    <strong>{{ __('Start') }}:</strong>
			                    <input type="text" name="start"  class="form-control event" value="{{old('start')}}" >
			                </div>
			                @error('start')
							<div class="invalid-feedback">{{ $errors->first('start') }}</div>
							@enderror
			            </div>
			            <div class="col-xs-12 col-sm-12 col-md-12">
			                <div class="form-group @error('attendee') is-invalid @enderror">
								<strong>{{__('Attendees')}}:</strong>
								<select class="form-select" multiple aria-label="attendee" id="attendee" name="attendee[]" >
								@foreach($roles as $key => $role)
								    <option  value="{{$role->name}}" {{$role->name == 'Admin' ? 'disabled' : ''  }}  >{{ $role->name }}  </option>
								    
								@endforeach
								</select>
							</div>
							@error('attendee')
							<div class="invalid-feedback">{{ $errors->first('attendee') }}</div>
							@enderror
			            </div>
			        </div>
			        

		        <div class="card-body">
		        	<a href="{{ route('home') }}" class="btn btn-secondary" >{{__('Close')}}</a>
					<button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
		        </div>
		    </form>
		  </div>  
		
	</div>
</div>
<script>

     $( function() {
    //$( ".event" ).datepicker( $.datepicker.regional[ "fr" ] );
    $( ".event" ).datepicker({
    	firstDay: 1,	
        dateFormat : "dd-mm-yy",
        
    });
  } );
    
</script>




@endsection