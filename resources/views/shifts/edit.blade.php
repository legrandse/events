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
		    <h2>{{__('Edit shift')}}</h2>
		    </div>
		    
		   <form action="{{ route('updateShift',['shift'=>$shift->id]) }}" id="eventconfirm" method="POST">
			@method('PATCH')
			@csrf
		    <div class="card-body">
		    
		        
		         	
			         <div class="row">
			            
			            <div class="form-group col-md-4">
			                <label for="time">{{__('Start')}}</label>
			                <div class="input-group date" >
			                    <input type="text" class="form-control time" id="start" name="start" value="{{$shift->start}}">
			                    
			                </div>
			            </div>
			            
			            <div class="form-group col-md-4">
			                <label for="time">{{__('End')}}</label>
			                <div class="input-group date" >
			                    <input type="text" class="form-control time" id="end" name="end" value="{{$shift->end}}">
			                </div>
			            </div>
			            
			             <div class="form-group col-md-4">
			                <label for="time">{{__('Attendee')}}</label>
			            
			            @livewire('shift-edit-search-user',['shift'=>$shift])
			            
			           
						</div>
						
						<div class="input-group mb-3 mt-2">
						  <div class="input-group-text">
						    <input class="form-check-input mt-0" type="checkbox" name="checkbox" value="1" aria-label="Checkbox for following text input">
						  </div>
						  <input type="text" class="form-control" aria-label="Text input with checkbox" value="{{__('Sending email to the attendee ?')}}">
						</div>

			            
			            
			            
			      	 </div>
			        
			</div>
		        <div class="card-body">
		        	<a href="{{ route('home') }}" class="btn btn-secondary" >{{__('Close')}}</a>
					<button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
		        </div>
		    </form>
		    <div class="card-body">
		      		<div class="form-group col-md-4">
		                <label for="time">{{__('Delete shift')}}</label>
		                <div class="input-group" >
		                    <form action="{{ route('shifts.destroy',['shift'=>$shift->id])}}"  method="post">
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
	$('.time').timepicker({
		
	});
	
</script>



@endsection