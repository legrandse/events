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
		    <h2>{{__('Add shift')}}</h2>
		    </div>
		    
		    <form action="{{ route('shifts.store') }}" method="POST">
		       @method('POST')
			  @csrf
		    <div class="card-body">
		    
		        
		         <div class="row">
		            <input type="hidden" class="form-control" name="event_id" value="{{ $event_id }}">
		            <input type="hidden" class="form-control" name="task_id" value="{{ $task_id }}">
		         
		            <div class="form-group col-md-6">
		                <label for="start">{{__('Start')}}</label>
		                <div class="input-group date @error('start') is-invalid @enderror" >
		                    <input type="text" class="form-control start"   name="start">
		                    
		                </div>
		                @error('start')
						    <div class="invalid-feedback">{{ $errors->first('start') }}</div>
						@enderror
		            </div>
		            
		            <div class="form-group col-md-6">
		                <label for="end">{{__('End')}}</label>
		                <div class="input-group date @error('end') is-invalid @enderror" >
		                    <input type="text" class="form-control end "  name="end">
		                  
		                </div>
		                @error('end')
						    <div class="invalid-feedback">{{ $errors->first('end') }}</div>
						@enderror
		            </div>
		            <div class="form-group col-md-6">
						<label class="col-sm-6 col-form-label" for="nbr_user_id">Bénév. nécessaire</label>
						<select class="form-select" aria-label="Default select example"  name="nbr_user_id"  >
											
						    <option class="form-control" value="1" >1</option>
						    <option class="form-control" value="2" >2</option>
						    <option class="form-control" value="3" >3</option>
						    <option class="form-control" value="4" >4</option>
						    <option class="form-control" value="5" >5</option>
						    <option class="form-control" value="6" >6</option>
						    <option class="form-control" value="7" >7</option>
						
						</select>
					
					</div>		
		            
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
<!--
<script>
	$('.start').timepicker({
		
	});
	$('.end').timepicker();
</script>-->
<script>
$( function() {
  	var timeFormat = 'hh:mm A';
	
      start = $('.start').timepicker({
			})
			
	.on( "change", function() {
          end.timepicker( getTime( this ) );
        }),
      end = $( ".end" ).timepicker({
			})
			
	
	
	.on( "change", function() {
        start.timepicker( getTime( this ) );
      });
 
    function getTime( element ) {
      var time;
      try {
        time = $.timepicker.parseDate( timeFormat, element.value );
      } catch( error ) {
        time = null;
      }
 
      return time;
    }
	
	
});
</script>



@endsection