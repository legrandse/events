<div>
    <form wire:submit.prevent="submit">
     
				<select class="form-select" aria-label="Default select example" name="user_id" >
					<option value="0">?</option>
				@foreach($users as $user)
				    <option class="form-control" value="{{$user->id}}" >{{ $user->name}}  </option>
				@endforeach
				</select>
			
			<td>
			<button type="submit" class="btn btn-primary">Send</button>
			</td>
			
			
				
		
	</form>
    
    
    
    
</div>
