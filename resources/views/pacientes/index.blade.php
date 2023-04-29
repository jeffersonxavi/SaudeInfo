@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Pacientes</h4>
          <a href="{{ route('pacientes.create') }}" class="btn btn-primary btn-sm text-white">
            <i class="fas fa-plus"></i> Adicionar Paciente
          </a>
        </div>
      </div>
      <div class="card-body">
        <table id="pacientes-table" class="table table-striped">
          <thead>
            <tr>
              <th>Nome</th>
              <th>E-mail</th>
              <th>Telefone</th>
              <th>Data de Nascimento</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pacientes as $paciente)
            <tr>
              <td>{{$paciente->nome}}</td>
              <td>{{$paciente->email}}</td>
              <td>{{$paciente->telefone}}</td>
              <td>{{$paciente->data_nascimento}}</td>
              <td>
                <a href="{{route('pacientes.edit', $paciente->id)}}" class="btn btn-sm btn-primary">Editar</a>
                <form action="{{route('pacientes.destroy', $paciente->id)}}" method="POST" style="display: inline-block">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  //adicionando DataTables
  let table = new DataTable('#pacientes-table', {
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
    },
  });
</script>

@endpush