@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Avisos</h4>
          <a href="{{ route('avisos.create') }}" class="btn btn-primary btn-sm text-white">
            <i class="fas fa-plus"></i> Adicionar Aviso
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="avisos-table" class="table table-striped">
            <thead>
              <tr>
                <th>Título</th>
                <th>Descrição</th>
                <th>Data Criação</th>
                <th>Data Expiração</th>
                <th>Data Aviso</th>
                <th>Prioridade</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


@push('scripts')
<script>
  //adicionando DataTables
  let table = new DataTable('#avisos-table', {
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json",
      "processing": "",
    },
    processing: true,
    serverSide: true,
    searching: true,
    autoWidth: false, // Desabilita a largura automática das colunas
    responsive: true, // Habilita a funcionalidade responsiva
    ajax: {
      url: "{{route('avisos.ajax')}}",
      method: 'GET',
    },
    columns: [{
        data: 'titulo',
        name: 'titulo'
      },
      {
        data: 'descricao',
        name: 'descricao'
      },
      {
        data: 'data_criacao',
        name: 'data_criacao'
      },
      {
        data: 'data_expiracao',
        name: 'data_expiracao'
      },
      {
        data: 'data_aviso',
        name: 'data_aviso'
      },
      {
        data: 'prioridade',
        name: 'prioridade',
      },
      {
        data: 'id',
        name: 'acoes',
        orderable: false,
        searchable: false,
        render: function(data, type, row, meta) {
          var editUrl = "{{ route('avisos.edit', ':id') }}".replace(':id', row.id);
          return `
            <div class="btn-group">
              <a href="${editUrl}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
              <button class="btn btn-sm btn-secondary delete-btn" data-id="${row.id}"><i class="far fa-trash-alt"></i></
            </div>
          `;
        }
      }
    ],

  });
  $(document).on('click', '.delete-btn', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    Swal.fire({

      title: 'Tem certeza?',
      text: 'Essa ação é irreversível.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Sim, excluir',
      cancelButtonText: 'Cancelar',
      allowOutsideClick: false,
      preConfirm: function() {
        return new Promise(function(resolve) {
          Swal.showLoading();
          $('.swal2-cancel').hide();
          const url = "{{route('pacientes.destroy', ':id')}}".replace(':id', id);
          $.ajax({
            url: url,
            type: 'POST',
            data: {
              _method: 'DELETE',
              _token: '{{ csrf_token() }}'
            },
            success: function() {
              table.ajax.reload();
              Swal.fire({
                title: 'Excluído!',
                text: 'O registro foi excluído com sucesso.',
                icon: 'success',
              });
              resolve();
            },
            error: function() {
              Swal.fire({
                title: 'Erro!',
                text: 'Ocorreu um erro ao excluir o registro.',
                icon: 'error'
              });
              resolve();
            }
          });
        });
      }
    });
  });
</script>
@endpush