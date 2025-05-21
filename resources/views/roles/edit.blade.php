@extends('layouts.app')


@section('content')
<div class="container">
<div class="row">

    <div class="col-lg-12 margin-tb">

        
        <div class="pull-right">

            <a class="btn btn-secondary" href="{{ route('roles.index') }}"> Back</a>

        </div>

    </div>

</div>


@if (count($errors) > 0)

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
			<h2>Edit Role</h2>
			</div>
			<div class="card-body">

				<form action="{{ route('roles.update',['role' => $role->id]) }}" method="post">
				@method('patch')
				@csrf

				<div class="row">

				    <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group">

				            <strong>Name:</strong>

				           <input type="text" class="form-control" name="name" value="{{ $role->name }}" />

				        </div>

				    </div>
				</div>
				<div class="row mt-2">
				    <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group">

				            <strong>Permission:</strong>

				            <br/>

				            @foreach($permission as $value)
				            <div class="form-check form-switch">
							  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" name="permission[]" value="{{ $value->id }}" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
							  <label class="form-check-label" for="flexSwitchCheckChecked">{{  $value->name }} </label>
							</div>
				            
				            
				            
				            
				               

				            
							
				            @endforeach

				        </div>

				    </div>

				    <div class="col-xs-12 col-sm-12 col-md-12 text-center">

				        <button type="submit" class="btn btn-primary">Submit</button>

				    </div>

				</div>

				</form>
		</div>
	</div>				
</div>
</div>

@endsection
