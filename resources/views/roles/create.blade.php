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
			<h2>Create Role</h2>
			</div>
			<div class="card-body">


				<form action="{{ route('roles.store') }}" method="post">
				@method('POST')
				@csrf
				<div class="row">

				    <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group">

				            <strong>Name:</strong>

				            <input type="text" class="form-control" name="name"  />

				        </div>

				    </div>

				    <div class="col-xs-12 col-sm-12 col-md-12">

				        <div class="form-group">

				            <strong>Permission:</strong>

				            <br/>

				            @foreach($permission as $value)

				                
								<label> <input type="checkbox" class="form-check-input" name="permission[]" value="{{ $value->id }}"/> {{ $value->name }} </label>
				            <br/>

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


@endsection