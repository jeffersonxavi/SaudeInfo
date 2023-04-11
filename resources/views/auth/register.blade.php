@extends('layouts.guest')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf
    <!-- Name -->
    <div class="form-group">
        <label for="name">{{ __('Name') }}</label>
        <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <!-- Email Address -->
    <div class="form-group mt-4">
        <label for="email">{{ __('Email') }}</label>
        <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="form-group mt-4">
        <label for="password">{{ __('Password') }}</label>
        <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password" />
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="form-group mt-4">
        <label for="password_confirmation">{{ __('Confirm Password') }}</label>
        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
    </div>

    <div class="form-group mt-4">
        <a class="text-sm text-primary" href="{{ route('login') }}">{{ __('Já tem conta?') }}</a>
    </div>

    <button type="submit" class="btn btn-primary mt-4">{{ __('Register') }}</button>
</form>
@endsection