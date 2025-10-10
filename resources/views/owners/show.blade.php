@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">{{ __('Owner Details') }}</div>
        <div class="card-body">
            <p><strong>{{ __('Organisation') }}:</strong> {{ $owner->organisation }}</p>
            <p><strong>{{ __('First Name') }}:</strong> {{ $owner->first_name }}</p>
            <p><strong>{{ __('Last Name') }}:</strong> {{ $owner->last_name }}</p>
            <p><strong>{{ __('Email') }}:</strong> {{ $owner->email }}</p>
            <p><strong>{{ __('GSM') }}:</strong> {{ $owner->gsm }}</p>
            <a href="{{ route('owners.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
        </div>
    </div>
</div>
@endsection
