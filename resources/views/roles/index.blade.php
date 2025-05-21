@extends('layouts.app')


@section('content')

<div class="container">
@if ($message = Session::get('success'))

    <div class="alert alert-success">

        <p>{{ $message }}</p>

    </div>

@endif

<div class="col-sm-12">		
		<div class="card">
			<div class="card-header bg-light py-3 d-flex flex-row align-items-center justify-content-between">
			<h2>Role Management</h2>
			@can('role-create')

            <a class="btn btn-success" href="{{ route('roles.create') }}"> <i class="fas fa-plus" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Add role"></i></a>

            @endcan
			</div>
			<div class="card-body">
				<table class="table table-striped">

			  

			     <th>No</th>

			     <th>Name</th>

			     <th >Action</th>
				 <th></th>
			  

			    @foreach ($roles as $key => $role)

			    <tr>

			        <td>{{ ++$i }}</td>

			        <td>{{ $role->name }}</td>

			        <td>

			            

			            @can('role-edit')

			                <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}"><i class="far fa-edit " data-bs-toggle="tooltip" 
								                        		data-bs-placement="left" 
								                        		data-bs-title="Edit role"></i></a>

			            @endcan
					</td>
					<td>
			            @can('role-delete')
							<form action="{{ route('roles.destroy',['role'=> $role->id]) }}"
				               @method('DELETE')
				               @csrf
								<button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
			                </form>

			            @endcan

			        </td>

			    </tr>

			    @endforeach

			</table>
			</div>
	</div>
</div>
</div>
{!! $roles->render() !!}




@endsection