@extends('layouts.app')

@section('content')
<style>
  /* Centralizar elementos nas colunas */
  .dataTables_wrapper table.dataTable thead th,
  .dataTables_wrapper table.dataTable tbody td {
    text-align: center;
    vertical-align: middle;
    /* padding: 1px;
    height: 2px;
    font-size: 15px; */
  }
</style>
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header bg-primary-custom">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Agenda de Profissionais</h4>
          <a href="{{ route('agendas.create') }}" class="btn btn-primary btn-sm text-white">
            <i class="fas fa-plus"></i> Agenda
          </a>
        </div>
      </div>
      <div class="card-body">
        <table id="agendas-table" class="table">
          <thead>
            <tr>
              <th>Profissional</th>
              <th>Tipo</th>
              <th>Início</th>
              <!-- <th>Intervalo</th> -->
              <th>Fim</th>
              <th>Segunda</th>
              <th>Terça</th>
              <th>Quarta</th>
              <th>Quinta</th>
              <th>Sexta</th>
              <th>Sábado</th>
              <th>Domingo</th>
              <th>Máx Aten.</th>
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
  $(document).ready(function() {
    let table = new DataTable('#agendas-table', {
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json",
        "processing": "Processando...",
      },
      processing: true,
      serverSide: true,
      searching: true,
      autoWidth: false, // Desabilita a largura automática das colunas
      responsive: true, // Habilita a funcionalidade responsiva
      scrollX: true, // Adicione esta opção para permitir rolagem horizontal
      ajax: {
        url: "{{ route('agendas.ajax') }}",
        method: 'GET',
      },
      columns: [{
          data: 'profissional.nome',
          name: 'profissional.nome',
          render: function(data) {
            var nomePartes = data.split(' ');
            var primeiroNome = nomePartes[0];
            var segundoNome = nomePartes[1];
            return primeiroNome + ' ' + segundoNome;
          }
        },
        {
          data: 'profissional.tipo_profissional',
          name: 'profissional.tipo_profissional'
        },
        {
          data: 'inicio_atendimento',
          name: 'inicio_atendimento'
        },
        // {
        //   data: 'intervalo',
        //   name: 'intervalo'
        // },
        {
          data: 'fim_atendimento',
          name: 'fim_atendimento'
        },
        {
          data: 'segunda',
          name: 'segunda',
          render: renderDay,
        },
        {
          data: 'terca',
          name: 'terca',
          render: renderDay,
        },
        {
          data: 'quarta',
          name: 'quarta',
          render: renderDay,
        },
        {
          data: 'quinta',
          name: 'quinta',
          render: renderDay,
        },
        {
          data: 'sexta',
          name: 'sexta',
          render: renderDay,
        },
        {
          data: 'sabado',
          name: 'sabado',
          render: renderDay,
        },
        {
          data: 'domingo',
          name: 'domingo',
          render: renderDay,
        },
        {
          data: 'max_atendimentos',
          name: 'max_atendimentos'
        },
        {
          data: 'id',
          name: 'acoes',
          orderable: false,
          searchable: false,
          render: function(data, type, row, meta) {
            var editUrl = "{{ route('agendas.edit', ':id') }}".replace(':id', row.id);
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

      drawCallback: function() {

        // Atualize a tabela para refletir as mudanças de largura
        table.columns.adjust().draw();
      }

    });

    function renderDay(data) {
      return data ? '<i title="Trabalha" class="fas fa-check text-success"></i>' : '<i title="Não trabalha" class="fas fa-times text-danger"></i>';
    }

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
            const url = "{{route('agendas.destroy', ':id')}}".replace(':id', id);
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
  });
</script>
@endpush