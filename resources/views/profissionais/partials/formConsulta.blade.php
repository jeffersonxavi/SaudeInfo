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

    .custom-modal .modal-dialog {
        max-width: 800px;
        /* Defina a largura desejada para o modal */
        margin: 1.75rem auto;
        /* Ajuste a margem conforme necessário */
    }

    #createLaudoModal.modal {
        overflow-y: scroll;
    }

    .campo-label {
        font-weight: bold;
        color: #333;
    }
</style>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>{{$profissional->nome}}</h4>
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
            <!-- <div class="col-md-4">
                <label for="filtro-profissional">Filtrar por profissional:</label>
                <input type="text" id="filtro-profissional" class="form-control" placeholder="Insira o nome do profissional">
            </div> -->
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="consultas_profissional-table" class="table table-hover table-striped">
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
    <!--Modal de criação de laudo -->
    <div class="modal fade custom-modal" id="createLaudoModal" tabindex="-1" role="dialog" aria-labelledby="createLaudoModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content p-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="createLaudoModalLabel"></h5>
                    <span class="badge badge-success ml-2"></span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('laudos-salvar.ajax') }}" method="POST" id="createLaudoForm">
                        @csrf
                        <input type="hidden" name="consulta_id" id="consulta_id">
                        <input type="hidden" name="tipo_consulta_id" id="tipo_consulta_id">
                        <input type="hidden" name="profissional_id" id="profissional_id">
                        <input type="hidden" name="profissional" id="profissional" value="{{$profissional->id}}">
                        <input type="hidden" name="paciente_id" id="paciente_id">
                        <input type="hidden" name="laudo_id" id="laudo_id">
                        <input type="hidden" name="data" id="data" value="{{date('Y-m-d')}}">
                        <p><span class="campo-label">Tipo de Consulta:</span> <span id="tipoConsulta_nome" name="tipo_consulta_id"></span></p>
                        <p><span class="campo-label">Profissional:</span> <span id="profissional_nome" name="profissional_id"></span></p>
                        <p><span class="campo-label">Paciente:</span> <span id="paciente_nome" name="paciente_id"></span></p>
                        <div class="form-group">
                            <label for="motivo_consulta">Motivo da Consulta:</label>
                            <textarea name="motivo_consulta" id="motivo_consulta" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="diagnostico">Diagnóstico:</label>
                            <textarea name="diagnostico" id="summernote_diagnostico" cols="30" rows="10" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tratamento_recomendado">Tratamento Recomendado:</label>
                            <textarea name="tratamento_recomendado" id="summernote_tratamento" cols="30" rows="10" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar Laudo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<!-- Inclua o CSS do DataTables -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"> -->

<!-- Inclua o Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />

<script>
    $(document).ready(function() {
        $('#summernote_diagnostico').summernote({
            height: 220, // Defina a altura desejada do editor
            placeholder: 'Exemplo: Fratura óssea constatada no exame radiológico',
        });
        $('#summernote_tratamento').summernote({
            height: 120, // Defina a altura desejada do editor
            placeholder: 'Exemplo: Prescrição do medicamento X, a ser tomado duas vezes ao dia após as refeições.' // Adicione o placeholder desejado

        });
    });
    //Remover o padding-right adicionado
    $('#createLaudoModal').on('hidden.bs.modal', function(e) {
        $('body').css('padding-right', '0');
        $('#createLaudoModalLabel').text("");
        $('#profissional_nome').text("");
        $('#paciente_nome').text("");
        $('#tipoConsulta_nome').text("");
        $('.badge').text("");
        $('#motivo_consulta').text("");
        $('#summernote_diagnostico').summernote('reset');
        $('#summernote_tratamento').summernote('reset');
        $('#summernote').summernote('reset');
    });
    $(document).off('click', '.create-laudo-btn').on('click', '.create-laudo-btn', function() {
        var consultaId = $(this).data('consulta-id');

        $.ajax({
            url: '/consultas/' + consultaId, // Rota para obter os detalhes da consulta
            method: 'GET',
            // async: false,

            success: function(response) {
                var modalTitle = $('#createLaudoModalLabel');
                var badge = $('.badge');

                if (response.laudo && response.laudo.id) {
                    modalTitle.text("Editar Laudo");
                    badge.text("Laudo Gerado");
                } else {
                    modalTitle.text("Criar Laudo");
                    badge.text("");
                }

                // Preencher os atributos com o nome
                $('#profissional_nome').text(response.profissional.nome);
                $('#paciente_nome').text(response.paciente.nome);
                $('#tipoConsulta_nome').text(response.tipo_consulta.nome);
                $('#motivo_consulta').text(response.laudo && response.laudo.motivo_consulta ? response.laudo.motivo_consulta : '');
                $('#summernote_diagnostico').summernote('code', response.laudo && response.laudo.diagnostico ? response.laudo.diagnostico : '');
                $('#summernote_tratamento').summernote('code', response.laudo && response.laudo.tratamento_recomendado ? response.laudo.tratamento_recomendado : '');
                $('#laudo_id').val(response.laudo && response.laudo.id ? response.laudo.id : '');

                // Preencher os atributos com id
                $('#consulta_id').val(response.id);
                $('#tipo_consulta_id').val(response.tipo_consulta.id);
                $('#profissional_id').val(response.profissional.id);
                $('#paciente_id').val(response.paciente.id);

            },
            error: function(xhr) {
                // Lidar com o erro da requisição, se necessário
            }
        });
    });
    $(document).off('submit', '#createLaudoForm').on('submit', '#createLaudoForm', function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize();

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            success: function(response) {
                // // Exibir SweetAlert de sucesso
                // Swal.fire('Sucesso', response.message, 'success');
                // // Limpar o formulário
                // form.trigger('reset');
                // // window.location.reload();
                // $('#createLaudoModal').modal('hide');
                // $('body').removeClass('modal-open');
                // $('.modal-backdrop').remove();
                $('#createLaudoModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                Swal.fire('Sucesso', response.message, 'success')
                    .then(() => {
                        // Limpar o formulário
                        form.trigger('reset');

                        window.location.reload();
                    });
            },
            error: function(xhr) {
                // Exibir SweetAlert de erro
                Swal.fire('Erro', 'Ocorreu um erro ao criar o laudo', 'error');
            }
        });
    });
</script>

<script>
    var profissionalId = $('#profissional').val();
    // Adicionando DataTables
    table = new DataTable('#consultas_profissional-table', {
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json",
            "processing": "",
        },
        processing: true,
        serverSide: true,
        searching: true,
        // async: false,
        fixedHeader: true, // Opção para fixar o cabeçalho da tabela
        autoWidth: false, // Desabilita a largura automática das colunas
        responsive: true, // Habilita a funcionalidade responsiva
        // scrollX: true, // Adicione esta opção para permitir rolagem horizontal
        ajax: {
            url: "{{ route('profissional.buscarConsulta') }}",
            method: 'GET',
            data: function(d) {
                d.profissionalId = profissionalId;
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
                    var createLaudoUrl = "{{ route('laudos.create', ['consulta_id' => ':consulta_id']) }}".replace(':consulta_id', row.id);
                    var gerarPdfUrl = "{{ route('gerar.pdf', ':id') }}".replace(':id', row.id);
                    return `
                        <div class="btn-group">
                        <button class="btn btn-sm btn-success create-laudo-btn" data-consulta-id="${row.id}" data-toggle="modal" data-target="#createLaudoModal">
                            ${row.laudo ? '<i class="far fa-file-alt" title="Laudo Gerado"></i>' : '<i class="far fa-plus-square" title="Gerar Laudo"></i>'}
                        </button>
                            ${row.laudo ? `<a href="${gerarPdfUrl}" target="_blank" class="btn btn-sm btn-danger"><i class="far fa-file-pdf"></i></a>` : `<button class="btn btn-sm btn-danger" disabled><i class="far fa-file-pdf"></i></button>`}
                        <a href="${editUrl}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
                        <button class="btn btn-sm btn-secondary delete-btn" data-id="${row.id}"><i class="far fa-trash-alt"></i></button>
                        </div>
                    `;
                }
            }

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
            // $('#filtro-profissional').on('keyup', function() {
            //     table.column(2).search(this.value).draw();
            // });

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
    $('#consultas_profissional-table').on('change', '.status-select', function() {
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