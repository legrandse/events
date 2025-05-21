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
		    <h2>{{__('Add task')}}</h2>
		    </div>
		    
		    <form action="{{ route('tasks.store') }}" method="POST">
		       @method('POST')
			  @csrf
		    <div class="card-body">
		    
		        
		         <div class="row">
		            <div class="col-xs-12 col-sm-12 col-md-12">
		                <div class="form-group @error('name') is-invalid @enderror">
		                    <strong>{{ __('Name') }}:</strong>
		                    <input type="text" name="name" class="form-control text-capitalize" placeholder="{{__('Name')}}">
		                    <input type="hidden" name="event_id" value="{{ $event_id }}">
		                </div>
		                @error('name')
						<div class="invalid-feedback">{{ $errors->first('name') }}</div>
						@enderror
		            </div>
		            
		            <div class="col-xs-12 col-sm-12 col-md-12">
		                <div class="form-group">
		                    <strong>{{ __('Details') }}:</strong>
		                    <textarea class="form-control" style="height:150px" name="description" placeholder="{{__('Detail')}}"></textarea>
		                </div>
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





@endsection