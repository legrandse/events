@extends('layouts.app')


@section('content')

<div class="container">

<!-- Alert Content -->
		@if ($message = Session::get('success'))

<div class="alert alert-success">

  <p>{{ $message }}</p>

</div>

@endif
@livewire('search-user')
	
</div>
@endsection