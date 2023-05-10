@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Profissional / {{$profissional->nome}}</h4>
                    <a href="{{ route('profissionais.index') }}" class="btn btn-outline-secondary btn-sm text-white">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
                @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show my-custom-alert" role="alert">
                    <strong>Sucesso {{ explode(' ', $profissional->nome)[0] }}!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
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
                    <a class="nav-link" data-toggle="tab" href="#tab3">
                        <i class="fas fa-stethoscope"></i>
                        <span>Especialidades</span>
                    </a>
                </li>
            </ul>
            <form id="form-profissional" method="POST" action="{{ route('profissionais.update', $profissional->id) }}">
                @csrf
                @method('PUT')
                <div class="tab-content mt-3">
                    <div id="tab1" class="tab-pane fade show active">
                        @include('profissionais.partials.form')
                    </div>
                    <div id="tab2" class="tab-pane fade">
                        @include('profissionais.partials.formPaciente')
                    </div>
                    <div id="tab3" class="tab-pane fade">
                        @include('profissionais.partials.formEspecialidade')
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection