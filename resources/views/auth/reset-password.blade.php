@extends('layouts.guest')

@section('content')
<form method="POST" action="{{ route('password.store') }}">
    @csrf

    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <!-- Email Address -->
    <div>
        <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
        <input id="email" class="block mt-1 w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
        @if ($errors->get('email'))
        <div class="mt-2 text-sm text-red-600">
            @foreach ($errors->get('email') as $error)
            {{ $error }}<br>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Password -->
    <div class="mt-4">
        <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
        <input id="password" class="block mt-1 w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300" type="password" name="password" required autocomplete="new-password" />
        @if ($errors->get('password'))
        <div class="mt-2 text-sm text-red-600">
            @foreach ($errors->get('password') as $error)
            {{ $error }}<br>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm Password</label>
        <input id="password_confirmation" class="block mt-1 w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300" type="password" name="password_confirmation" required autocomplete="new-password" />
        @if ($errors->get('password_confirmation'))
        <div class="mt-2 text-sm text-red-600">
            @foreach ($errors->get('password_confirmation') as $error)
            {{ $error }}<br>
            @endforeach
        </div>
        @endif
    </div>

    <div class="flex items-center justify-end mt-4">
        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Reset Password
        </button>
    </div>
</form>
@endsection