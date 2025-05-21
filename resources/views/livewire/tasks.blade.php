<div>
 <a  href="" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#createTaskModal{{$event->id}}" ><i class="fas fa-layer-group " data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ __('Add Task') }}"></i></a>
 
 @if($showForm)   
<div class="container">
	    
			    <div>

			        @if (session()->has('message'))

			            <div class="alert alert-success">

			                {{ session('message') }}

			            </div>

			        @endif

    			</div>
	
	<div class="modal fade" id="createTaskModal{{$event->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h1 class="modal-title fs-5" id="exampleModalLabel">{{__('Add task')}}</h1>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form wire:submit="save">
	      <div class="modal-body">
	        		<div class="row">
			            <div class="col-xs-12 col-sm-12 col-md-12">
			                <div class="form-group @error('name') is-invalid @enderror">
			                    <strong>{{ __('Name') }}:</strong>
			                    <input type="text" id="taskInput" class="form-control text-capitalize" placeholder="{{__('Name')}}" wire:model="name" >
			                    <input type="hidden"  value="{{ $event_id }}" wire:model="event_id">
			                </div>
			                @error('name')
							<div class="invalid-feedback">{{ $errors->first('name') }}</div>
							@enderror
			            </div>
			            
			            <div class="col-xs-12 col-sm-12 col-md-12">
			                <div class="form-group">
			                    <strong>{{ __('Details') }}:</strong>
			                    <textarea class="form-control" style="height:150px" wire:model="description" placeholder="{{__('Detail')}}"></textarea>
			                </div>
			            </div>
			            
			        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
	        <button type="button" type="submit"  class="btn btn-primary">{{ __('Save changes') }}</button>
	        <span wire:loading>Saving...</span> 
	       
	      </div>
	      </form>
	    </div>
	  </div>
	</div>

</div>
@endif
	@foreach($tasks as $task)
        @if($task->event_id == $event->id)
       
        <div class="accordion-item" >
            <h2 class="accordion-header " id="task{{$task->id}}Three">
            
                <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" 
                    data-bs-target="#e{{ $task->id }}Three" 
                    aria-expanded="false" 
                    aria-controls="e{{ $task->id }}Three"> 
                   
                    <a href="#" class="btn btn-light " data-bs-toggle="modal" data-bs-target="#taskEditModal{{ $task->id }}" ><i class="fas fa-cogs" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{{ __('Edit task') }}"></i></a>&nbsp;
                    
                 <span class="text-capitalize">{{ $task->name ?? 'empty' }} </span>  
                    	
                 </button>
                 
                	 
            </h2>
	        <div id="e{{ $task->id }}Three" class="accordion-collapse collapse " aria-labelledby="task{{$task->id}}Three" data-bs-parent="#accordionTask{{ $event->id }}">
	                
	                <div class="accordion-body ">
	                
	                
	                
	            	</div>
	            
	        </div>
        </div>
		
		
		@endif <!-- task -->
        @endforeach <!-- task -->
	<script>
	    document.addEventListener('livewire:init', () => {
	       Livewire.on('close-modal', (event) => {
	           $('#createTaskModal{{$event->id}}' ).modal('hide');
	       });
	    });
	</script>
</div>
