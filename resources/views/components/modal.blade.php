<!-- Modal Shift -->
<div class="modal fade" id="{{$id}}" tabindex="-1" aria-labelledby="{{$shift}}ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="{{shift}}ModalLabel">Add shift pour {{ $task->name }} </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('shifts.store') }}" method="POST">
      @method('POST')
      @csrf
      <div class="modal-body">
        		{{$body}}
		        
		         <div class="row">
		            <input type="hidden" class="form-control" name="event_id" value="{{ $event->id }}">
		            <input type="hidden" class="form-control" name="task_id" value="{{ $task->id }}">
		         
		            <div class="form-group col-md-6">
		                <label for="time">Start</label>
		                <div class="input-group date" id="timePicker">
		                    <input type="text" class="form-control" id="start" name="start">
		                    <span class="input-group-addon"><i class="fas fa-clock-o" aria-hidden="true"></i></span>
		                </div>
		            </div>
		            
		            <div class="form-group col-md-6">
		                <label for="time">End</label>
		                <div class="input-group date" id="timePicker">
		                    <input type="text" class="form-control" name="end">
		                    <span class="input-group-addon"><i class="fas fa-clock-o" aria-hidden="true"></i></span>
		                </div>
		            </div>
		            <div class="form-group col-md-6">
					<label class="col-sm-6 col-form-label" for="user">Bénév. nécessaire</label>
					<select class="form-select" aria-label="Default select example"  name="nbr_user_id"  >
										
					    <option class="form-control" value="1" >1</option>
					    <option class="form-control" value="2" >2</option>
					    <option class="form-control" value="3" >3</option>
					    <option class="form-control" value="4" >4</option>
					    <option class="form-control" value="5" >5</option>
					
					</select>
					
					</div>		
		            
		        </div>
		    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>