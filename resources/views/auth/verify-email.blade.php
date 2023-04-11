@extends('layouts.guest')

@section('content')
<div class="mb-4 text-sm text-gray-600">
    <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
</div>
@if (session('status') == 'verification-link-sent')
<div class="mb-4 font-medium text-sm text-success">
    <p>A new verification link has been sent to the email address you provided during registration.</p>
</div>
@endif

<div class="mt-4 d-flex justify-content-between">
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">
            Resend Verification Email
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-secondary">
            Log Out
        </button>
    </form>
</div>
@endsection