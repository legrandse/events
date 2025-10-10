@extends('layouts.site')
@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>{{ __('Whoops!') }}</strong> {{ __('There were some problems with your input.') }}<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">{{ __('Add Owner') }}</div>
        <div class="card-body">
            <form action="{{ route('owners.store') }}" method="POST">
                @csrf
                <div class="mb-3">
				    <label>{{ __('Product') }}</label>
				    <select name="product_id" class="form-select">
				        <option value="">{{ __('Select Product') }}</option>
				        @foreach($prices as $price)
				            <option value="{{ $price->id }}" {{ old('product_id', $owner->product_id ?? '') == $price->id ? 'selected' : '' }}>
				                {{ $price->product }} - {{ $price->amount }}
				            </option>
				        @endforeach
				    </select>
				</div>
                <div class="mb-3">
                    <label>{{ __('Organisation') }}</label>
                    <input type="text" name="organisation" class="form-control" value="{{ old('organisation') }}">
                </div>
                <div class="mb-3">
                    <label>{{ __('First Name') }}</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
                </div>
                <div class="mb-3">
                    <label>{{ __('Last Name') }}</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
                </div>
                <div class="mb-3">
                    <label>{{ __('Email') }}</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label>{{ __('GSM') }}</label>
                    <input type="text" name="gsm" class="form-control" value="{{ old('gsm') }}">
                </div>
                <a href="{{ route('owners.index') }}" class="btn btn-secondary">{{ __('Close') }}</a>
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
