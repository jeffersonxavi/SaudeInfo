@extends('layouts.app')

@section('content')
<style>
  /* Centralizar elementos nas colunas */
  .dataTables_wrapper table.dataTable thead th,
  .dataTables_wrapper table.dataTable tbody td {
    vertical-align: middle;
    padding: 5px;
    font-size: 15px;
  }
</style>
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header bg-primary-custom">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Tipo de Consultas</h4>
          <a href="{{ route('tipos-consultas.create') }}" class="btn btn-primary btn-sm text-white">
            <i class="fas fa-plus"></i> Tipo de Consulta
          </a>
        </div>
      </div>
      <div class="card-body">
        <table id="tipos-consultas-table" class="table table-striped">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Especialidade</th>
              <th>Descrição</th>
              <th>Duração</th>
              <th>Valor</th>
              <th>Ações</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  //adicionando DataTables
  let table = new DataTable('#tipos-consultas-table', {
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json",
      "processing": "",
    },
    processing: true,
    serverSide: true,
    searching: true,
    ajax: {
      url: "{{route('tipos-consultas.ajax')}}",
      method: 'GET',
    },
    columns: [{
        data: 'nome',
        name: 'nome'
      },
      {
        data: 'especialidade.nome',
        name: 'especialidade.nome'
      },
      {
        data: 'descricao',
        name: 'descricao'
      },
      {
        data: 'duracao_estimada',
        name: 'duracao_estimada',
        render: function(data, type, row) {
          if (type === 'display') {
            var duracao = data;
            var horas = Math.floor(duracao / 60);
            var minutos = duracao % 60;

            var duracaoFormatada = "";

            if (horas > 0) {
              duracaoFormatada = horas + ' hora' + (horas > 1 ? 's' : '');
            }

            if (minutos > 0) {
              duracaoFormatada += (duracaoFormatada !== "" ? ' ' : '') + minutos + ' minuto' + (minutos > 1 ? 's' : '');
            }

            return duracaoFormatada;
          }

          return data;
        }
      },
      {
        data: 'valor',
        name: 'valor',
        render: function(data, type, row) {
          if (type === 'display') {
            return new Intl.NumberFormat('pt-BR', {
              style: 'currency',
              currency: 'BRL'
            }).format(data);
          }

          return data;
        }
      },
      {
        data: 'id',
        name: 'acoes',
        orderable: false,
        searchable: false,
        render: function(data, type, row, meta) {
          var editUrl = "{{ route('tipos-consultas.edit', ':id') }}".replace(':id', row.id);
          return `
            <div class="btn-group">
              <a href="${editUrl}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
              <button class="btn btn-sm btn-secondary delete-btn" data-id="${row.id}"><i class="far fa-trash-alt"></i></
            </div>
          `;
        }
      },
    ],
    columnDefs: [{
        targets: '_all',
        className: 'border-right'
      }, // Adiciona borda à direita de todas as células
      {
        targets: '_all',
        className: 'border-left'
      }, // Adiciona borda à esquerda de todas as células
      {
        targets: '_all',
        className: 'border-bottom'
      }, // Adiciona borda inferior em todas as células
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
          const url = "{{ route('tipos-consultas.destroy', ':id') }}".replace(':id', id);
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