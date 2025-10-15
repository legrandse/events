@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
	        @if ($message = Session::get('success'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
			    <strong>{{ $message }}</strong>
			    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{__('Close')}}"></button>
			</div>
			@endif
			<div class="card">
  				<div class="card-body text-bg-light p-3 mb-2">
					<canvas id="myChart" ></canvas>
				</div>
			</div>
			<div class="accordion " id="accordionExample">
			    @can('event-create')
			    <!-- Event button -->
			    <a href="{{route('events.create')}}" class="btn btn-secondary" ><i class="fas fa-calendar-plus" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{__('Add event')}}"></i></a>
				<br><br>
			    @endcan
			    @foreach($events as $event)
				
           		
			    <div class="accordion-item">
			   <!-- Display events if allowed -->
			        <div class="accordion-header " 

			        @for($i=0; $i < count(auth()->user()->roles->pluck('id')); $i++)
				     {{--   @if(auth()->user()->roles->pluck('id')[$i] != 1 && auth()->user()->roles->pluck('id')[$i] != 2 && (!in_array(auth()->user()->roles->pluck('name')[$i] , $event->attendee)  || $event->submited == 0 ))
				        	hidden 
				        @endif --}}
				    @if(auth()->user()->cannot('event-edit')  && (!in_array(auth()->user()->roles->pluck('name')[$i] , $event->attendee)  || $event->submited == 0 ))
				        	hidden 
				        @endif    
				        
			       @endfor
			        id="heading">
			            <div class="col lg-12 d-flex flex-row align-items-center justify-content-between">
				            <button  class="accordion-button collapsed mb-0
				            				@can('event-list') 
				                        							                        	
												@if($totalShiftsByEvents[$event->id]['shifts_count'] > 0)
												    
										        {{
										            $totalShiftsByEvents[$event->id]['confirmed_shifts_count'] / $totalShiftsByEvents[$event->id]['shifts_count'] == 1 ? 'alert alert-success' :
										            (\Carbon\Carbon::parse($event->start)->lte(now()->addDays(7)) ? 'alert alert-danger' :
										            (\Carbon\Carbon::parse($event->start)->lte(now()->addDays(12)) ? 'alert alert-warning' : ''))
										        }}
												    
												@endif
				                        		
				                        	@endcan" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$event->id}}" 
			            		aria-expanded="false" 
			            		aria-controls="collapse{{$event->id}}">
			            		@can('event-edit')
			            		<!-- Edit event button -->
			            		
			            		<a href="{{ route('events.edit',['event' => $event->id]) }}" class="btn btn-secondary "><i class="fas fa-cogs" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{{ __('Edit event') }}"></i></a>&nbsp;
			            		
			            		<!-- Shift submit button -->
								<a class="btn btn-warning openModalBtn" data-modal-id="sendingShiftModal{{ $event->id }}" data-bs-target="#sendingShiftModal{{ $event->id }}" @if($event->submited > 0 || !array_key_exists($event->id, $missingShift)) hidden @endif>
  <i class="fas fa-paper-plane" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{__('Sending shift')}}"></i>
</a>&nbsp;&nbsp;   	
			            		@endcan
			            		<strong>{{ date('d/m/Y',strtotime($event->start))  }}</strong>:&nbsp;  <span class="text-capitalize">{{$event->name}}</span>
			            		
		            		</button>
		            		      
	            		</div>	        
	            	</div>
			         
			        <div id="collapse{{$event->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$event->id}}" data-bs-parent="#accordionExample">
			        
			            <div class="accordion" id="accordionTask{{ $event->id }}">
				            
				            <div class="accordion-body" id="test">
				            @can('task-create')
				             <div class="d-flex justify-content-between align-items-center mb-1">
							    <!-- Add Task button -->
							    <a href="{{ route('tasks.create', ['event_id' => $event->id]) }}" 
							       class="btn btn-secondary">
							        <i class="fas fa-layer-group" 
							           data-bs-toggle="tooltip" 
							           data-bs-placement="right" 
							           data-bs-title="{{ __('Add Task') }}">
							        </i>
							    </a>

							    <h4>
							        {{ __('Required attendee :') }}
							        <span class="badge text-bg-secondary">
							          {{ $totalShiftsByEvents[$event->id]['confirmed_shifts_count'] }} / {{ $totalShiftsByEvents[$event->id]['shifts_count'] }}
							        </span>
							    </h4>
							</div>
				            <br><br>
				          	<!-- Form submit for all tasks in the event-->
					          	<form action="{{ route('massupdate') }}"  method="post" id="formShift{{ $event->id }}" >
					            @method('PATCH')   
								@csrf	
				            @endcan
				                
				                @foreach($event->tasks as $task)
				                @if($task->event_id == $event->id)
				                
				                <div class="accordion-item" >
				                    <h2 class="accordion-header " id="task{{$task->id}}Three">
				                    
				                        <button class="accordion-button collapsed mb-0
				                        	@can('task-create') 
				                        	
					                        	@if($totalShiftsByEvents[$event->id]['shifts_count'] > 0)
													    
											        {{
											            $totalShiftsByEvents[$event->id]['confirmed_shifts_count'] / $totalShiftsByEvents[$event->id]['shifts_count'] == 1 ? 'alert alert-success' :
											            (\Carbon\Carbon::parse($event->start)->lte(now()->addDays(7)) ? 'alert alert-danger' :
											            (\Carbon\Carbon::parse($event->start)->lte(now()->addDays(12)) ? 'alert alert-warning' : ''))
											        }}
													    
												@endif
				                        		
				                        	@endcan " type="button" data-bs-toggle="collapse" 
					                        data-bs-target="#e{{ $task->id }}Three" 
					                        aria-expanded="false" 
					                        aria-controls="e{{ $task->id }}Three"> 
					                        
					                        <!-- Edit task button -->
					                        @can('task-edit')
					                        <a href="{{ route('tasks.edit',['task'=>$task->id]) }}" class="btn btn-secondary " ><i class="fas fa-cogs" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{{ __('Edit task') }}"></i></a>&nbsp;
					                        @endcan
					                        
					                        <!-- Info button -->
					                            <span class="text-capitalize">{{ $task->name ?? 'empty' }} </span>
					                        	@if($task->description != null)&nbsp;&nbsp;
					                        	<a href="#" class="btn btn-info" data-bs-toggle="popover" data-bs-title="{{__('Extra info')}}" data-bs-content="{{  $task->description}}"><i class="fas fa-info"></i></a>
					                        	@endif
					                        	
					                     </button>
					                </h2>
				                    <div id="e{{ $task->id }}Three" class="accordion-collapse collapse @hasrole('Bénévole') show @endhasrole " aria-labelledby="task{{$task->id}}Three" data-bs-parent="#accordionTask{{ $event->id }}">
				                        
				                        <div class="accordion-body table-responsive 
				                        	@cannot('event-edit') 
				                        	
					                        	@if($totalShiftsByEvents[$event->id]['shifts_count'] > 0)
													    
											        {{
											            $totalShiftsByEvents[$event->id]['confirmed_shifts_count'] / $totalShiftsByEvents[$event->id]['shifts_count'] == 1 ? 'alert alert-success' :
											            (\Carbon\Carbon::parse($event->start)->lte(now()->addDays(7)) ? 'alert alert-danger' :
											            (\Carbon\Carbon::parse($event->start)->lte(now()->addDays(12)) ? 'alert alert-warning' : ''))
											        }}
													    
												@endif
				                        		
				                        	@endcannot ">
				                        @can('shift-create')
				                        
				                        <!-- Add Shift button -->
				                        <a href="{{ route('shifts.create',['event_id'=>$event->id,'task_id'=>$task->id]) }}" class="btn btn-secondary" ><i class="fas fa-clock" data-bs-toggle="tooltip" data-bs-placement="right"	data-bs-title="{{__('Add shift')}}"></i></a>
				                        
				                        @endcan
				                        	<table class="table table-sm table-hover align-left">
												<th>{{ __('Start') }}</th>
												<th>{{ __('End') }}</th>
												<th>Bénévole(s)</th>
												@can('shift-create')
												<th>{{ __('Conf.') }}</th>
												<th>{{__('Edit')}}</th>
												@endcan
												
												@foreach($task->shifts as $shift)
												@if($shift->event_id == $event->id && $shift->task_id == $task->id)
													@hasrole('Bénévole')
													<form action="{{ route('shifts.update',['shift'=>$shift]) }}" id="confirmShift{{ $shift->id }}" method="post"  >
							                       		@method('PATCH')   
														@csrf
							                        @endhasrole
												<tr>
													<td>
														<input type="hidden"  name="shift_id[]" value="{{ $shift->id }}">
														<input type="hidden"  name="task_id[]" value="{{ $task->id }}">
														<input type="hidden"  name="event_id" value="{{ $event->id }}">
														
														{{ date('H:i',strtotime($shift->start)) }}
													</td>
													<td>
														{{ date('H:i',strtotime($shift->end)) }}  
												    </td>
													<td>
													@hasrole('Bénévole')
														<input type="hidden"  name="user_id" value="{{ auth()->user()->id }}">

														@if($shift->user_id > 0 || $shift->user_id != null)
															<input type="submit" class="btn @if(auth()->user()->id == $shift->user_id) btn-warning @else btn-success @endif" @if($shift->is_confirmed > 0) disabled @endif value="{{ $shift->user->firstname ?? ''}} {{$shift->user->name ?? 'User Deleted' }}">
														@else
														
															<button type="button" data-bs-toggle="modal" data-bs-target="#shiftModalConfirmation{{ $shift->id }}"  class="btn btn-primary" 
															@if( array_key_exists($event->id, $userShiftStart) )
															
																@if($shift->task_id == $task->id && in_array($shift->start,$userShiftStart[$event->id]) ) disabled @endif
															
															@endif
															">C'est pour moi </button>
															
														@endif
													
													@endhasrole
													@can('event-edit')
														
														<input type="hidden" class="form-control" readonly name="user_id[]" value="{{ $shift->user->id ?? '0'}}">
														<input type="text" class="form-control" readonly  value="{{ $shift->user->firstname ?? ''}} {{ $shift->user->name ?? '?' }}">
													
													
													</td>
												
													<td>@if($shift->is_confirmed > 0)
															 <div class="btn btn-success"><i class="fas fa-check "></i></div>
														@else 
															<div  class="btn btn-warning"><i class="fas fa-question"></i></div>
														@endif
															
													</td>
													<td><a href="{{route('shifts.edit',['shift'=>$shift->id])}}" class="btn btn-light" ><i class="fas fa-cog" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{{ __('Edit shift') }}"></i></a>
													</td>
													@endcan
												</tr>
													@hasrole('Bénévole')
													</form>
													@endhasrole
													
													<!-- Modal confirm shift -->
					
													<div class="modal fade" id="shiftModalConfirmation{{ $shift->id }}" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
													  <div class="modal-dialog">
													    <div class="modal-content">
													      <div class="modal-header">
													        <h1 class="modal-title fs-5">{{__('Shift Confirmation')}}</h1>
													        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													      </div>
													      <div class="modal-body">
													      {{__('Are you sure to subscribe for: ')}}<br>
													      <strong>{{ $task->name}}</strong> {{__('from ')}} {{date('H:i',strtotime($shift->start))}} {{__('to ')}}{{date('H:i',strtotime($shift->end))}} ?
													      </div>
													      <div class="modal-footer">
													        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
													        <button type="submit" form="confirmShift{{ $shift->id }}" class="btn btn-primary">{{__('Save changes')}}</button>
													      </div>
													    </div>
													  </div>
													</div>
													
												@endif <!-- shift -->
												@endforeach <!-- shift -->
											</table>
											
				                        </div>
				                        
				                    </div>
				                    
				                </div>
				                
								
								
								
								
								
								@endif <!-- task -->
				                @endforeach <!-- task -->
				                
				                @can('event-edit')
								<!-- Modal confirm sending shift -->
					
								<div class="modal fade" id="sendingShiftModal{{ $event->id }}" data-bs-backdrop="false"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header">
								        <h1 class="modal-title fs-5" id="exampleModalLabel">{{__('Do you want to send shifts ?')}}</h1>
								        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								      </div>
								      <div class="modal-body">
								      
								      <div class="input-group mb-3">
										  <div class="input-group-text">
										    <input class="form-check-input mt-0" type="checkbox" name="SMS" value="1" aria-label="Checkbox for following text input">
										  </div>
										  <input type="text" class="form-control" aria-label="Text input with checkbox" value="{{__('Sending SMS to attendee ?')}}">
									  </div>

								      
								      
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
								        <button type="submit" form="formShift{{ $event->id }}" class="btn btn-primary">{{__('Save changes')}}</button>
								      </div>
								    </div>
								  </div>
								</div>
								
								
								
								</form> <!-- massupdate form -->
								@endcan
				                
				                
				               
				            </div>
			            </div>
			        </div>
			    </div>
			  
						
								
								
			    @endforeach <!-- event -->
			    
								
					

				
			</div>
        </div>
        
    </div>
</div>


	
<script>
	$(".alert-dismissible").fadeTo(2000, 500).slideUp(500, function(){
    $(".alert-dismissible").slideUp(500);
});
	
</script>

<!--<script>
function taskConfirm() {
  confirm( 'Veuillez svp confirmer votre participation à la tâche.' );
}
</script>
-->
<script>
	// Obtenir la partie de l'URL après le signe #
const hash = window.location.hash;

// Séparer les identifiants de l'URL en un tableau
const identifiers = hash.split('#').filter(item => item !== '');

// Vérifier chaque identifiant dans le tableau
identifiers.forEach(identifier => {
    if (identifier.includes('collapse')) {
        // Si l'identifiant est pour l'accordéon
        const eventIdFromHash = identifier.replace('collapse', '');
        const eventId = parseInt(eventIdFromHash, 10);
        
        const elementToOpen = document.querySelector(`#collapse${eventId}`);
        if (elementToOpen) {
            elementToOpen.classList.add('show');
        }
    } else if (identifier.includes('shift')) {
        // Si l'identifiant est pour le shift
        const shiftIdFromHash = identifier.replace('shift', '');
        const shiftId = parseInt(shiftIdFromHash, 10);
        const shiftElementToOpen = document.querySelector(`#e${shiftId}Three`);
        if (shiftElementToOpen) {
            shiftElementToOpen.classList.add('show');
        }
    }
});
</script>
<script>
var xValues = @json($xValues);
var yValues = @json($yValues);
var barColors = [];
for (var i = 0; i < 10; i++) {
    var randomColor = "#" + Math.floor(Math.random()*16777215).toString(16);
    barColors.push(randomColor);
}
var currentYear = new Date().getFullYear();

new Chart("myChart", {
  type: "doughnut",
  data: {
    labels: xValues,
    datasets: [{
    	label: '# participations',
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
  	responsive: true,
  	maintainAspectRatio : true,
  	aspectRatio : 2, // Désactive le maintien du ratio d'aspect
    plugins : {
    title: {
      display: true,
      text: "Félicitations aux bénévoles les plus impliqués en " + currentYear
    }
	}
  }
});
</script>


@endsection
