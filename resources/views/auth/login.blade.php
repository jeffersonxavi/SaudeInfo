@extends('layouts.guest')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    <!-- Email Address -->
    <div class="form-group">
        <label for="email">{{ __('Email') }}</label>
        <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" :value="old('email')" required autofocus autocomplete="username">
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <!-- Password -->
    <div class="form-group mt-3">
        <label for="password">{{ __('Password') }}</label>
        <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password">
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <!-- Remember Me -->
    <div class="form-group form-check mt-3">
        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
        <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
    </div>

    <div class="form-group row mb-0 mt-3">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Log in') }}
            </button>

            @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif
        </div>
    </div>
</form>
@endsection