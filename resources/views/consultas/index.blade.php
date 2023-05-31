@extends('layouts.app')

@section('content')
<style>
  /* Centralizar elementos nas colunas */
  .dataTables_wrapper table.dataTable thead th,
  .dataTables_wrapper table.dataTable tbody td {
    text-align: center;
    vertical-align: middle;
    /* padding: 5px;
    font-size: 15px; */
  }

  .status {
    display: flex;
    align-items: center;
  }

  .icon {
    margin-right: 2px;
  }

  .icon.agendada {
    color: #ffcc00;
    /* Amarelo para status "Agendada" */
  }

  .icon.confirmada {
    color: #00cc00;
    /* Verde para status "Confirmada" */
  }

  .icon.em-andamento {
    color: #3366ff;
    /* Azul para status "Em andamento" */
  }

  .icon.realizada {
    color: #009933;
    /* Verde mais escuro para status "Realizada" */
  }

  .icon.cancelada {
    color: #ff0000;
    /* Vermelho para status "Cancelada" */
  }

  .icon.ausente {
    color: #cc3300;
    /* Vermelho escuro para status "Ausente" */
  }

  .icon.remarcada {
    color: #9900cc;
    /* Roxo para status "Remarcada" */
  }
</style>
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Consultas</h4>
          <a href="{{ route('consultas.create') }}" class="btn btn-primary btn-sm text-white">
            <i class="fas fa-plus"></i> Consulta
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <label for="filtro-data">Filtrar por data:</label>
            <div class="input-group">
              <?php
              // Definindo fuso horário São Paulo
              date_default_timezone_set('America/Sao_Paulo');
              ?>
              <input name="filtro-data" type="date" id="filtro-data" class="form-control" placeholder="Selecione a data" value="{{date('Y-m-d')}}">
              <button id="limpar-filtro-data" class="btn btn-outline-secondary" type="button">Mostrar todas</button>
            </div>
          </div>
          <div class="col-md-2">
            <label for="filtro-hora">Filtrar por horário:</label>
            <input type="text" id="filtro-hora" class="form-control" placeholder="Insira o horário">
          </div>
          <div class="col-md-4">
            <label for="filtro-profissional">Filtrar por profissional:</label>
            <input type="text" id="filtro-profissional" class="form-control" placeholder="Insira o nome do profissional">
          </div>
        </div>
      </div>
        <div class="card-body">
        <div class="table-responsive">
          <table id="consultas-table" class="table table-hover table-striped">
            <thead>
              <tr>
                <th>Paciente</th>
                <th>Tipo de Consulta</th>
                <th>Profissional</th>
                <th>Dia Marcado</th>
                <th>Dia Atendimento</th>
                <th>Hora</th>
                <th>Duração</th>
                <!-- <th>Descrição</th> -->
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@push('scripts')
<script>
  // Adicionando DataTables
  let table = new DataTable('#consultas-table', {
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json",
      "processing": "",
    },
    processing: true,
    serverSide: true,
    searching: true,
    // autoWidth: false, // Desabilita a largura automática das colunas
    // responsive: true, // Habilita a funcionalidade responsiva
    // scrollX: true, // Adicione esta opção para permitir rolagem horizontal
    ajax: {
      url: "{{ route('consultas.ajax') }}",
      method: 'GET',
      data: function(d) {
        // Verifique se foi fornecida uma data no filtro
        let filtroData = $('#filtro-data').val();
        // Adicione o parâmetro de data à solicitação apenas se uma data válida for fornecida
        if (filtroData) {
          d.data = filtroData;
        }
      },
    },
    columns: [{
        data: 'paciente.nome',
        name: 'paciente.nome',
        render: function(data, type, row) {
          var nomePartes = data.split(' ');
          var primeiroNome = nomePartes[0];
          var segundoNome = nomePartes[1] || '';
          // var cpfNumeros = row.paciente.cpf.substring(0, 3);
          // + ' - CPF (' + cpfNumeros + '-XXX..)'; add no return
          return primeiroNome + ' ' + segundoNome;
        }
      },

      {
        data: 'tipoConsulta.nome',
        name: 'tipoConsulta.nome'
      },
      {
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
        data: 'dia_marcacao',
        name: 'dia_marcacao',
        render: function(data) {
          var marcacao = new Date(data); // Data da marcação
          marcacao.setHours(marcacao.getHours() + 3); // Ajuste para o horário local do Brasil

          var today = new Date(); // Data atual

          var options = {
            weekday: 'long',
            month: 'long',
            day: 'numeric'
          };

          if (marcacao.toDateString() === today.toDateString()) {
            return 'Hoje';
          } else if (marcacao.toDateString() === new Date(today.getTime() - 24 * 60 * 60 * 1000).toDateString()) {
            return 'Ontem';
          } else {
            var diffTime = Math.abs(today.getTime() - marcacao.getTime());
            var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays <= 7) {
              var weekday = marcacao.toLocaleDateString('pt-BR', {
                weekday: 'long'
              });
              return 'Última(o) ' + weekday.charAt(0).toLowerCase() + weekday.slice(1);
            } else {
              return marcacao.toLocaleDateString('pt-BR', options);
            }
          }
        }
      },
      {
        data: 'dia_consulta',
        name: 'dia_consulta',
        render: function(data) {
          var consulta = new Date(data); // Data da consulta
          consulta.setHours(consulta.getHours() + 3); // Ajuste para o horário local do Brasil

          var today = new Date(); // Data atual

          var options = {
            weekday: 'long',
            month: 'long',
            day: 'numeric'
          };

          if (consulta.toDateString() === today.toDateString()) {
            return '📅 Hoje (' + consulta.toLocaleDateString('pt-BR', {
              weekday: 'long'
            }) + ', ' + consulta.getDate() + ')';
          } else if (consulta.getDate() - today.getDate() === 1) {
            return 'Amanhã (' + consulta.toLocaleDateString('pt-BR', {
              weekday: 'long'
            }) + ', ' + consulta.getDate() + ')';
          } else {
            return consulta.toLocaleDateString('pt-BR', options);
          }
        }
      },
      {
        data: 'hora_consulta',
        name: 'hora_consulta'
      },
      {
        data: 'tipoConsulta.duracao_estimada',
        name: 'tipoConsulta.duracao_estimada',
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
      // {
      //   data: 'descricao',
      //   name: 'descricao'
      // },
      {
        data: 'status',
        name: 'status',
        render: function(data, type, row, meta) {
          var statusOptions = {
            1: 'Agendada',
            2: 'Confirmada',
            3: 'Em andamento',
            4: 'Realizada',
            5: 'Cancelada',
            6: 'Ausente',
            7: 'Remarcada'
          };

          var selectOptions = '';
          for (var key in statusOptions) {
            var selected = (key == data) ? 'selected' : '';
            selectOptions += `<option value="${key}" ${selected}>${statusOptions[key]}</option>`;
          }

          // Verifica se a hora atual está dentro da faixa de tempo da consulta
          var horaAtual = new Date().getHours();
          var horaConsulta = new Date(row.hora).getHours();
          if (horaConsulta === horaAtual) {
            data = 3; // Define o valor do status como "Em andamento"
          }

          var statusIcons = {
            1: '<i class="fas fa-calendar-alt icon agendada" title="Agendada" data-toggle="tooltip"></i>',
            2: '<i class="fas fa-check-circle icon confirmada" title="Confirmada" data-toggle="tooltip"></i>',
            3: '<i class="fas fa-spinner icon em-andamento" title="Em andamento" data-toggle="tooltip"></i>',
            4: '<i class="fas fa-check icon realizada" title="Realizada" data-toggle="tooltip"></i>',
            5: '<i class="fas fa-times-circle icon cancelada" title="Cancelada" data-toggle="tooltip"></i>',
            6: '<i class="fas fa-user-times icon ausente" title="Ausente" data-toggle="tooltip"></i>',
            7: '<i class="fas fa-sync icon remarcada" title="Remarcada" data-toggle="tooltip"></i>'
          };

          var icon = statusIcons[data] || '<i class="fas fa-question"></i>';
          var selectHtml = `
            <div class="status-select-wrapper d-flex align-items-center">
              <div class="status-icon mr-2">${icon}</div>
              <select class="form-control status-select" data-id="${row.id}">
                ${selectOptions}
              </select>
            </div>
          `;
          return selectHtml;
        },
      },
      {
        data: 'id',
        name: 'acoes',
        orderable: false,
        searchable: false,
        render: function(data, type, row, meta) {
          var editUrl = "{{ route('consultas.edit', ':id') }}".replace(':id', row.id);
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
    initComplete: function() {
      // Filtro por nome do profissional
      $('#filtro-profissional').on('keyup', function() {
        table.column(2).search(this.value).draw();
      });

      // Filtro por data de atendimento
      $('#filtro-data').on('change', function() {
        table.column(4).search(this.value).draw();
      });

      // Filtro por hora de atendimento
      $('#filtro-hora').on('keyup', function() {
        table.column(5).search(this.value).draw();
      });
    },

  });
  // Manipulador de evento para alterações no select do status
  $('#consultas-table').on('change', '.status-select', function() {
    var consultaId = $(this).data('id');
    var novoStatus = $(this).val();
    var iconElement = $(this).closest('.status-select-wrapper').find('.status-icon');

    // Faça uma requisição AJAX para atualizar o status no backend
    $.ajax({
      url: "{{ route('consultas.updateStatus') }}",
      method: 'POST',
      data: {
        consultaId: consultaId,
        novoStatus: novoStatus,
        "_token": "{{ csrf_token() }}"
      },
      success: function(response) {
        // Atualize o ícone com base no novo status
        var statusIcons = {
          1: '<i class="fas fa-calendar-alt icon agendada" title="Agendada" data-toggle="tooltip"></i>',
          2: '<i class="fas fa-check-circle icon confirmada" title="Confirmada" data-toggle="tooltip"></i>',
          3: '<i class="fas fa-spinner icon em-andamento" title="Em andamento" data-toggle="tooltip"></i>',
          4: '<i class="fas fa-check icon realizada" title="Realizada" data-toggle="tooltip"></i>',
          5: '<i class="fas fa-times-circle icon cancelada" title="Cancelada" data-toggle="tooltip"></i>',
          6: '<i class="fas fa-user-times icon ausente" title="Ausente" data-toggle="tooltip"></i>',
          7: '<i class="fas fa-sync icon remarcada" title="Remarcada" data-toggle="tooltip"></i>'
        };
        var icon = statusIcons[novoStatus] || '<i class="fas fa-question"></i>';
        iconElement.html(icon);
        console.log(response);
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  });

  // Botão Limpar Filtro Data
  $('#limpar-filtro-data').on('click', function() {
    $('#filtro-data').val('');
    table.search('').columns().search('').draw();
  });

  $(document).on('click', '.delete-btn', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    const nome = $(this).closest('tr').find('td:eq(0)').text(); // Obtém o nome da pessoa na primeira coluna da linha
    Swal.fire({
      title: 'Tem certeza?',
      text: `Deseja realmente excluir a consulta de "${nome}"?`,
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
          const url = "{{ route('consultas.destroy', ':id') }}".replace(':id', id);
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