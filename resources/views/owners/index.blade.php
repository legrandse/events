@extends('layouts.app')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h2>{{ __('Owners') }}</h2>
        <a class="btn btn-primary" href="{{ route('owners.create') }}">{{ __('Add Owner') }}</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>{{ __('Organisation') }}</th>
                <th>{{ __('First Name') }}</th>
                <th>{{ __('Last Name') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('GSM') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($owners as $owner)
            <tr>
                <td>{{ $owner->organisation }}</td>
                <td>{{ $owner->first_name }}</td>
                <td>{{ $owner->last_name }}</td>
                <td>{{ $owner->email }}</td>
                <td>{{ $owner->gsm }}</td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('owners.show', $owner) }}">{{ __('View') }}</a>
                    <a class="btn btn-warning btn-sm" href="{{ route('owners.edit', $owner) }}">{{ __('Edit') }}</a>
                    <form action="{{ route('owners.destroy', $owner) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
