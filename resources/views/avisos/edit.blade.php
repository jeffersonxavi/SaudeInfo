@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header bg-primary-custom">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Aviso / {{ $aviso->titulo }}</h4>
          <a href="{{ route('avisos.index') }}" class="btn btn-outline-secondary btn-sm text-white">
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
          <form method="POST" action="{{ route('avisos.update', $aviso->id) }}">
            @csrf
            @method('PUT')
            @include('avisos.partials.form')
            <div class="form-group mt-3 text-end">
              <x-primary-button>{{ __('Salvar') }}</x-primary-button>
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