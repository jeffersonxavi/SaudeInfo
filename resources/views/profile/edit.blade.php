@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="mb-6">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="mb-6">
            @include('profile.partials.update-password-form')
        </div>
        <div>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection