@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col">
    <div class="card">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#tab1">
            <i class="fa fa-home"></i> Dados
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#tab2">
            <i class="fa fa-user"></i> Consultas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#tab3">
            <i class="fa fa-user"></i> Laudos
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#tab4">
            <i class="fa fa-user"></i> Exames
          </a>
        </li>
      </ul>

      <div class="tab-content">
        <div id="tab1" class="tab-pane fade show active">
          <form method="POST" action="">
    @csrf
    @method('PUT')
    
    <div class="form-group row">
              <label for="name" class="col-sm-3 control-label">Nome</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name',) }}" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="cpf" class="col-sm-3 control-label">CPF</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="cpf" name="cpf" value="{{ old('cpf', ) }}" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="birth_date" class="col-sm-3 control-label">Data de Nascimento</label>
              <div class="col-sm-9">
                <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date', ) }}" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="phone_number" class="col-sm-3 control-label">Telefone</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', ) }}" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-sm-3 control-label">E-mail</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email',) }}" required>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
                </div>
                
  
  </form>

          <p>Conteúdo da aba 1.</p>
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
      
      <div class="card-body">
        <div class="text-center mb-4">
          <button class="btn btn-lg btn-primary" type="submit">ENTRAR</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection