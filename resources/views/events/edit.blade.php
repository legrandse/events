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
		    <h2>{{__('Edit event')}}</h2>
		    </div>
		    
		   <form action="{{ route('events.update',['event'=>$event->id]) }}" id="eventconfirm" method="POST">
			@method('PATCH')
			@csrf
		    <div class="card-body">
		    
		        
		         	
			        <div class="row">
			            <div class="col-xs-12 col-sm-12 col-md-12">
			                <div class="form-group">
			                    <strong>{{ __('Name') }}:</strong>
			                    <input type="text" name="name" class="form-control text-capitalize" value="{{$event->name}}">
			                </div>
			            </div>
			            <div class="col-xs-12 col-sm-12 col-md-12">
			                <div class="form-group">
			                    <strong>{{ __('Start') }}:</strong>
			                    <input type="text" name="start"  class="form-control event" value="{{ date('d-m-Y',strtotime($event->start)) }}" >
			                </div>
			            </div>
			            <div class="col-xs-12 col-sm-12 col-md-12">
			                <div class="form-group @error('attendee') is-invalid @enderror">
								<strong>{{__('Attendees')}}:</strong>
								
								<select class="form-select" multiple aria-label="attendee" id="attendee" name="attendee[]" >
								@foreach($roles as $key => $role)
								    <option  value="{{$role->name}}" {{$role->name == 'Admin' ? 'disabled' : ''  }} {{ in_array($role->name, $event->attendee) ? 'selected' : '' }} >{{ $role->name }}  </option>
								    
								@endforeach
								</select>
							</div>
							@error('attendee')
							<div class="invalid-feedback">{{ $errors->first('attendee') }}</div>
							@enderror
			            </div>
			            @hasrole(1)
			            <div class="col-xs-12 col-sm-12 col-md-12">
			                <div class="form-group">
			                    <strong>{{ __('Publish event ?') }}:</strong>
			                    <input type="checkbox" name="submited"  class="form-check-input" value="1" {{ old('submited',$event->submited) == 1 ? 'checked' : '' }}>
			                </div>
			            </div>
			            @endhasrole
			        <!--    <div class="col-xs-12 col-sm-12 col-md-12">
			                <div class="form-group">
			                    <strong>End:</strong>
			                    <input type="date" name="end" class="form-control" >
			                </div>
			            </div>-->
			        </div>
			        
			</div>
		        <div class="card-body">
		        	<a href="{{ route('home') }}" class="btn btn-secondary" >{{__('Close')}}</a>
					<button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
		        </div>
		    </form>
		    <div class="card-body">
		      		<div class="form-group col-md-4">
		                <label for="time">{{__('Delete event')}}</label>
		                <div class="input-group" >
		                    <form action="{{ route('events.destroy',['event'=>$event->id])}}"  method="post">
		                    @method('DELETE')
		                    @csrf
						  		
		                    <button type="submit"  class="btn btn-danger"><i class="fas fa-trash"></i></button>
							</form>											                    
		                </div>
				    </div>
		      </div>
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