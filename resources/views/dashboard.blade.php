@extends('layouts.app')

@section('content')
<div class="px-4">
    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
</div>
<div class="p-6 text-gray-900 dark:text-gray-100">
    @can('user')
    Sistema para o projeto de TCC - SAÚDETECH
    @elsecan('admin')
    Sistema para o projeto de TCC - Somente ADMIN
    @endcan
</div>

@endsection