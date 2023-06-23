@extends('layouts.app')

@section('content')
@push('scripts')
<script>
    //Remover o padding-right adicionado
    $('#createLaudoModal').on('hidden.bs.modal', function(e) {
        $('body').css('padding-right', '0');
        $('body').css('padding-left', '0');
    });
</script>
@endpush
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header bg-primary-custom">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Profissional / {{$profissional->nome}}</h4>
                    <a href="{{ route('profissionais.index') }}" class="btn btn-outline-secondary btn-sm text-white">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
                @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show my-custom-alert" role="alert">
                    <strong>Sucesso, {{ explode(' ', $profissional->nome)[0] }}!</strong> {{ session('success') }}
                    <button type="button" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
                <script>
                    setTimeout(function() {
                        $('.alert-success').fadeOut('slow');
                    }, 4000);
                </script>
                @endif
            </div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab1">
                        <i class="fas fa-user"></i>
                        <span>Dados</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab2">
                        <i class="fas fa-users"></i>
                        <span>Pacientes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab4">
                        <i class="fas fa-stethoscope"></i>
                        <span>Consultas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab3">
                        <i class="fas fa-stethoscope"></i>
                        <span>Especialidades</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content mt-3">
                <div id="tab1" class="tab-pane fade show active">
                    <form id="form-profissional" method="POST" action="{{ route('profissionais.update', $profissional->id) }}">
                        @csrf
                        @method('PUT')
                        @include('profissionais.partials.form')
                        <div class="form-group mt-3 text-end">
                            <x-primary-button>{{ __('Salvar') }}</x-primary-button>
                        </div>
                    </form>
                </div>
                <div id="tab2" class="tab-pane fade">
                    <form id="form-profissional" method="POST" action="{{ route('profissionais.update', $profissional->id) }}">
                        @csrf
                        @method('PUT')
                        @include('profissionais.partials.formPaciente')
                    </form>
                </div>
                <div id="tab4" class="tab-pane fade">
                    @include('profissionais.partials.formConsulta')
                </div>
                <div id="tab3" class="tab-pane fade">
                    <form id="form-profissional" method="POST" action="{{ route('especialidades.update', $profissional->id) }}">
                        @csrf
                        @method('PUT')
                        @include('profissionais.partials.formEspecialidade')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush