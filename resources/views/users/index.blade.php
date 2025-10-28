@extends('layouts.app')


@section('content')

<div class="container">

<!-- Alert Content -->
@if ($message = Session::get('success'))
<div class="alert alert-success">
	<p>{{ $message }}</p>
</div>
@endif
<!-- Alert limit Plan -->
@if ($message = Session::get('limit'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>{{ $message }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{__('Close')}}"></button>
</div>
@endif


@livewire('search-user')
	
</div>
@endsection