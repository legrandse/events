@extends('layouts.app')
@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">{{ __('Edit Owner') }}</div>
        <div class="card-body">
            <form action="{{ route('owners.update', $owner) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>{{ __('Organisation') }}</label>
                    <input type="text" name="organisation" class="form-control" value="{{ old('organisation', $owner->organisation) }}">
                </div>
                <div class="mb-3">
                    <label>{{ __('First Name') }}</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $owner->first_name) }}">
                </div>
                <div class="mb-3">
                    <label>{{ __('Last Name') }}</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $owner->last_name) }}">
                </div>
                <div class="mb-3">
                    <label>{{ __('Email') }}</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $owner->email) }}">
                </div>
                <div class="mb-3">
                    <label>{{ __('GSM') }}</label>
                    <input type="text" name="gsm" class="form-control" value="{{ old('gsm', $owner->gsm) }}">
                </div>
                <a href="{{ route('owners.index') }}" class="btn btn-secondary">{{ __('Close') }}</a>
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
