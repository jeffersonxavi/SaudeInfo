@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Tipos de Consultas / {{ $tipoConsulta->nome }}</h4>
          <a href="{{ route('tipos-consultas.index') }}" class="btn btn-outline-secondary btn-sm text-white">
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
      </ul>
      <div class="tab-content mt-3">
        <div id="tab1" class="tab-pane fade show active">
          <form method="POST" action="{{ route('tipos-consultas.update', $tipoConsulta->id) }}">
            @csrf
            @method('PUT')
            @include('tipos_consultas.partials.form')
            <div class="form-group mt-3">
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection