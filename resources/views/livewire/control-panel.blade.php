<div>
	@if ($message = Session::get('success'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<strong>{{ $message }}</strong>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{__('Close')}}"></button>
	</div>
	@endif
	<div class="col-sm-12">		
		<div class="card">
			<div class="card-header bg-light py-3 d-flex flex-row align-items-center justify-content-between">
			<h2>Control panel</h2>
			</div>
			
			<div class="card-body">
				<form class="row g-3" wire:submit="save">
					<div class="col-auto">
				  		<label for="formFile" class="form-label">Logo </label>
					</div>
					
					
					<div class="col-auto">
					  
					      @if ($photo) 
					        <img src="{{ $photo->temporaryUrl() }}">
					    @endif
						    <input class="form-control" type="file" wire:model="photo">
						 
						    @error('photo') <span class="error">{{ $message }}</span> @enderror
					</div>
					<div class="col-auto">
						    <button class="btn btn-primary" type="submit">Save photo</button>
					</div>
					</form>
				

				<hr />
				<form class="row g-3" wire:submit="saveArchiveValue()" > 
					<div class="form-check form-switch col-auto">
					
					  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault"  wire:click ="archiveButton" {{ $archiveToggle ? 'checked' : ''  }} >
					  <label class="form-check-label" for="flexSwitchCheckDefault">Default archive days</label>
					</div>
					
					<div class="col-auto">
					
					   <select wire:model="archiveValue"  class="form-select" aria-label="Default select example" {{ !$archiveToggle ? 'disabled' : ''  }} >
						 
						  @foreach($array as $key => $value)
						  <option value="{{$key}}" wire:key="{{ $key }}" >{{$value}}</option>
						  
						  @endforeach
						  
						</select>
					</div>
					<div class="col-auto">
						 <button class="btn btn-primary"  type="submit" {{ !$archiveToggle ? 'disabled' : ''  }}>Save</button>
					
					</div>
				</form>
				<hr />
				<div class="mb-3">
					<form class="row g-3" >
						<div class="col-auto">
						<label for="reset" class="form-label">Duplicate évènements</label>
						</div>
						<div class="col-auto">
							<select class="form-select" aria-label="Default select example" wire:model.live="event_id" >
								<option selected>Selectionner l'event</option>
								@foreach($events as $event)
								<option value="{{$event->id}}">{{$event->start.' '.$event->name}}</option>
								@endforeach
								
							</select>
						</div>
						<div class="col-auto">
							<button class="btn btn-danger" type="button" wire:click="duplicateEvent({{$event_id}})"  wire:confirm="Are you sure you want to duplicate this post?">Duplicate</button>
						</div>
					</form>
				</div>
				<hr />
				
				
				
				
			<div class="mb-3">
				  <label for="formFile" class="form-label">Default reminder 1 value </label>
				  <input class="form-control" type="number" >
				</div>
			<div class="mb-3">
				  <label for="formFile" class="form-label">Default reminder 2 value </label>
				  <input class="form-control" type="number" >
				</div>	
	
			<!--	<div class="form-check form-switch">
				  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
				  <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>
				</div>
				<div class="form-check form-switch">
				  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
				  <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label>
				</div>
				<div class="form-check form-switch">
				  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDisabled" disabled>
				  <label class="form-check-label" for="flexSwitchCheckDisabled">Disabled switch checkbox input</label>
				</div>
				<div class="form-check form-switch">
				  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckCheckedDisabled" checked disabled>
				  <label class="form-check-label" for="flexSwitchCheckCheckedDisabled">Disabled checked switch checkbox input</label>
				</div>-->


			</div>
		</div>
	</div>
</div>
