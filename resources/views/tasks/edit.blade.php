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
		    <h2>{{__('Edit task')}}</h2>
		    </div>
		    
		   <form action="{{ route('tasks.update',['task'=>$task->id]) }}" id="eventconfirm" method="POST">
			@method('PATCH')
			@csrf
		    <div class="card-body">
		    
		        
		         	
			        <div class="row">
			            <div class="col-xs-12 col-sm-12 col-md-12">
			                <div class="form-group">
			                    <strong>{{ __('Name') }}:</strong>
			                    <input type="text" name="name" class="form-control text-capitalize" value="{{ $task->name}} ">
			                    
			                </div>
			            </div>
			            
			            <div class="col-xs-12 col-sm-12 col-md-12">
			                <div class="form-group">
			                    <strong>{{ __('Details') }}:</strong>
			                    <textarea class="form-control" style="height:150px" name="description" placeholder="{{__('Detail')}}">{{ $task->description }}</textarea>
			                </div>
			            </div>
			            
			            <div class="col-xs-12 col-sm-12 col-md-12">
			                <div class="form-group">
			                    <strong>{{ __('Position') }}:</strong>
			                    <input type="text" name="position" class="form-control" value="{{ $task->position}} ">
			                    
			                </div>
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
		                <label for="time">{{__('Delete task')}}</label>
		                <div class="input-group" >
		                    <form action="{{ route('tasks.destroy',['task'=>$task->id])}}"  method="post">
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




@endsection