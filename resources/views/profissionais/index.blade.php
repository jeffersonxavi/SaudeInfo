@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Profissionais</h4>
          <a href="{{ route('profissionais.create') }}" class="btn btn-primary btn-sm text-white">
            <i class="fas fa-plus"></i> Adicionar Profissional
          </a>
        </div>
      </div>
      <div class="card-body">
        <table id="myTable" class="table table-striped">
          <thead>
            <tr>
              <th>Nome</th>
              <th>CRM</th>
              <th>CPF</th>
              <th>Telefone</th>
              <th>E-mail</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach($profissionais as $profissional)
            <tr>
              <td>{{$profissional->nome}}</td>
              <td>{{$profissional->crm}}</td>
              <td>{{$profissional->cpf}}</td>
              <td>{{$profissional->telefone}}</td>
              <td>{{$profissional->email}}</td>
              <td>
                <a href="{{route('profissionais.edit', $profissional->id)}}" class="btn btn-sm btn-primary">Editar</a>
                <form action="{{route('profissionais.destroy', $profissional->id)}}" method="POST" style="display: inline-block">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')

<script>
  //adicionando DataTables
  let table = new DataTable('#myTable', {
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
    }
  });
</script>
@endpush