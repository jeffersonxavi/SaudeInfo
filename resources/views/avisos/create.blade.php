@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header bg-primary-custom">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Cadastro de Aviso</h4>
                    <a href="{{ route('avisos.index') }}" class="btn btn-outline-secondary btn-sm text-white">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
            <div class="tab-content">
                <form method="POST" action="{{ route('avisos.store') }}">
                    @csrf
                    @include('avisos.partials.form')
                    <div class="form-group mt-3 text-end">
                        <x-primary-button>{{ __('Salvar') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection