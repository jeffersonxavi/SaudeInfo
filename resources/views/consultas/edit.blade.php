@extends('layouts.app')

@section('content')
<style>
  .modal .modal-dialog {
    max-width: 80%;
  }

  #novoLaudoModal.modal {
    overflow-y: scroll;
  }
</style>
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Consulta / {{ $consulta->paciente->nome }}</h4>
          <a href="{{ back()->getTargetUrl() }}" class="btn btn-outline-secondary btn-sm text-white">
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
            <i class="fas fa-file-alt"></i>
            <span>Laudo</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#tab3">
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
          @if ($laudo)
          <form method="POST" action="{{ route('laudos.update', ($laudo->id ?? '' ))}}">
            @csrf
            @method('PUT')
            @include('consultas.partials.formConsulta')
          </form>
          @else
          <p>Ainda não foi gerado Laudo.</p>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#novoLaudoModal">
            Inserir Laudo
          </button>
          @endif
          <div class="modal fade" id="novoLaudoModal" tabindex="-1" role="dialog" aria-labelledby="novoLaudoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="novoLaudoModalLabel">Novo Laudo</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  @include('consultas.partials.formConsulta')
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="tab3" class="tab-pane fade">
          <p>Conteúdo da aba 3.</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection