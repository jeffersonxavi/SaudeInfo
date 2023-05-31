@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Consulta / {{ $consulta->paciente->nome }}</h4>
          <a href="{{ route('consultas.index') }}" class="btn btn-outline-secondary btn-sm text-white">
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
            <i class="fas fa-calendar-alt"></i>
            <span>Consultas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#tab3">
            <i class="fas fa-file-alt"></i>
            <span>Laudos</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#tab4">
            <i class="fas fa-file-medical"></i>
            <span>Exames</span>
          </a>
        </li>
      </ul>
      <div class="tab-content mt-3">
        <div id="tab1" class="tab-pane fade show active">
          <form method="POST" action="{{ route('consultas.update', $consulta->id) }}">
            @csrf
            @method('PUT')
            @include('consultas.partials.form')
            <div class="form-group mt-3">
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </form>
        </div>
        <div id="tab2" class="tab-pane fade">
          <p>Conteúdo da aba 2.</p>
        </div>
        <div id="tab3" class="tab-pane fade">
          <p>Conteúdo da aba 3.</p>
        </div>
        <div id="tab4" class="tab-pane fade">
          <p>Conteúdo da aba 4.</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection