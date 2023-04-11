@extends('layouts.guest')

@section('content')
<div class="card-header">{{ __('Reset Password') }}</div>
<p>{{ __('Esqueceu sua senha? Sem problemas. Basta nos informar seu endereço de e-mail e enviaremos um e-mail com um link de redefinição de senha que permitirá que você escolha um novo.') }}</p>

<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <!-- Email Address -->
    <div class="form-group">
        <label for="email">{{ __('Email') }}</label>
        <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group mb-0">
        <button type="submit" class="btn btn-primary">{{ __('Email Password Reset Link') }}</button>
    </div>
</form>
@endsection