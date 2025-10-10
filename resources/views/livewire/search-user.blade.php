<div>

    

 	<div class="col-sm-12">		
		<div class="card">
			<div class="card-header bg-light py-3 d-flex flex-row align-items-center justify-content-between">
	    		<div class="col-lg-4  ">
	    			<input class="form-control" wire:model.live="search" type="text" placeholder="Search users..."/>  
	    		</div>
	    		<div class="col-lg-8 float-end  ">
	    			<a href="{{route('users.create')}}" class="btn btn-success pull-right"><i class="fas fa-user-plus" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Add user"></i></a>
	    		</div>
	  		</div>
		
				<div class="card-body">
						<table class="table table-striped">
							<thead>
								<tr>
									<th scope="col">#</th>		
									<th scope="col">Utilisateurs</th>
									<th></th>	
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($users as $user)
					      		<tr>
						      		<td>
						      			{{ $user->id }}
						      		</td>
						      		<td>
						      			{{ $user->firstname.' '.$user->name   }}
									</td>
						     		<td>
						     			<a class="btn btn-secondary" href="{{route('users.edit',['user'=>Crypt::encryptString($user->id)])}}"  ><i class="far fa-edit " data-bs-toggle="tooltip" 
								                        		data-bs-placement="left" 
								                        		data-bs-title="Edit user"></i></a>
							     		
						     		</td>
						     		<td>
						     		@can('user-delete')
						     			<button type="button"  class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" wire:click="showModals({{ $user->id }})"><i class="fas fa-trash"></i></button>
							     	@endcan	
						     		</td>
						     	</tr>
						      		
					      		
					      		@endforeach
								
							</tbody>
					     
					 </table>
				</div>
				<div class="card-body">{{ $users->links() }}</div>
			</div>
		</div>

	<!-- Modal confirm shift -->
					
									<div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  <div class="modal-dialog">
									    <div class="modal-content">
									      <div class="modal-header">
									        <h1 class="modal-title fs-5" id="exampleModalLabel">{{__('Delete Confirmation')}}</h1> 
									        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									      </div>
									      
									     
									      <div class="modal-body">
									      {{__('Are you sure to delete ')}} ?
									      </div>
									      <div class="modal-footer">
									        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
									        <button type="submit"  class="btn btn-danger close-modal" data-bs-dismiss="modal" wire:click.prevent="delete()">{{__('Save changes')}}</button>
									      </div>
									     
									    </div>
									  </div>
									</div>
									
</div>
