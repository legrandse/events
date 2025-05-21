<div>
	    <div class="container">
	    
			    <div>

			        @if (session()->has('message'))

			            <div class="alert alert-success">

			                {{ session('message') }}

			            </div>

			        @endif

    </div>
	<div class="col-sm-12">		
			<div class="card">
				<div class="card-header bg-light py-3 d-flex flex-row align-items-center justify-content-between">
			    <h2>{{__('Add task')}}</h2>
			    </div>
			    
			    <form wire:submit.prevent="submit">
			      
			    <div class="card-body">
			    
			        
			         <div class="row">
			            <div class="col-xs-12 col-sm-12 col-md-12">
			                <div class="form-group @error('name') is-invalid @enderror">
			                    <strong>{{ __('Name') }}:</strong>
			                    <input type="text"  class="form-control text-capitalize" placeholder="{{__('Name')}}" wire:model="name">
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

			        <div class="card-body">
			        	<a href="{{ route('home') }}" class="btn btn-secondary" >{{__('Close')}}</a>
						<button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
			        </div>
			    </form>
			  </div>  
			
		</div>
	</div>
</div>
