@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Cadastro de Profissional</h4>
                    <a href="{{ route('profissionais.index') }}" class="btn btn-outline-secondary btn-sm text-white">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
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
                        <i class="fas fa-stethoscope"></i>
                        <span>Especialidades</span>
                    </a>
                </li>
            </ul>
            <form id="form-profissional" method="POST" action="{{ route('profissionais.store') }}">
                @csrf
                <div class="tab-content mt-3">
                    <div id="tab1" class="tab-pane fade show active">
                        @include('profissionais.partials.form')
                    </div>
                    <div id="tab2" class="tab-pane fade">
                        @include('profissionais.partials.formEspecialidade')
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection