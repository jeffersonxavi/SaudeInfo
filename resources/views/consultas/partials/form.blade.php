<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="row">
                <?php
                // Definindo fuso horário São Paulo
                date_default_timezone_set('America/Sao_Paulo');
                ?>
                @if(isset($laudo))
                <input type="hidden" name="laudo" id="laudo">
                @endif
                <div class="form-group col-md-2">
                    <label for="dia_marcacao">Dia da Marcação:</label>
                    <input type="date" class="form-control" id="dia_marcacao" name="dia_marcacao" value="{{$consulta->dia_marcacao ?? date('Y-m-d') }}" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label for="dia_consulta">Dia da Consulta:</label>
                    <input type="date" class="form-control" id="dia_consulta" name="dia_consulta" required value="{{ $consulta->dia_consulta ?? ''  }}">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group col-md-3">
                    <label for="hora_consulta">Hora da Consulta:</label>
                    <input type="time" class="form-control" id="hora_consulta" name="hora_consulta" required value="{{ $consulta->hora_consulta ?? old('hora_consulta') }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="">Selecione o status</option>
                        @foreach([
                        1 => 'Agendada',
                        2 => 'Confirmada',
                        3 => 'Em andamento',
                        4 => 'Realizada',
                        5 => 'Cancelada',
                        6 => 'Ausente',
                        7 => 'Remarcada'
                        ] as $value => $status)
                        <option value="{{ $value }}" {{ isset($consulta) && $consulta->status == $value ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="paciente_id">Nome do Paciente:</label>
                <select class="form-control" id="paciente_id" name="paciente_id" required @if(isset($consulta)) disabled @endif>
                    <option value="">Selecione o paciente</option>
                    @if(isset($consulta))
                    <option value="{{ $consulta->paciente->id }}" {{ $consulta->paciente_id == $consulta->paciente->id ? 'selected' : '' }}>
                        {{ $consulta->paciente->nome }} - CPF: {{ $consulta->paciente->cpf }}
                    </option>
                    @endif
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="profissional_id">Nome do Profissional:</label>
                <select class="form-control" id="profissional_id" name="profissional_id" required @if(isset($consulta)) disabled @endif>
                    <option value="">Selecione o profissional</option>
                    @if(isset($consulta))
                    <option value="{{ $consulta->profissional->id }}" {{ $consulta->profissional_id == $consulta->profissional->id ? 'selected' : '' }}>
                        {{ $consulta->profissional->nome }}
                    </option>
                    @endif
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="tipo_consulta_id">Tipo de Consulta:</label>
                <select class="form-control" id="tipo_consulta_id" name="tipo_consulta_id" required>
                    <option value="">Selecione o tipo de consulta</option>
                    @foreach($tiposConsultas as $tipoConsulta)
                    <option value="{{ $tipoConsulta->id }}" {{ isset($consulta) && $consulta->tipo_consulta_id == $tipoConsulta->id ? 'selected' : '' }}>{{ $tipoConsulta->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-12">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao">{{ isset($consulta) ? $consulta->descricao : '' }}</textarea>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group col-md-12 text-center">
                        <label for="filtro-data" style="font-size: 20px; font-weight: bold;">Agenda de Consulta do Profissional</label>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="filtro-data">Filtrar por data de atendimento:</label>
                            <div class="input-group">
                                <?php
                                // Definindo fuso horário São Paulo
                                date_default_timezone_set('America/Sao_Paulo');
                                ?>
                                <!-- <input name="filtro-data" type="date" id="filtro-data" class="form-control" placeholder="Selecione a data" value="{{date('Y-m-d')}}"> -->
                                <button id="limpar-filtro-data" class="btn btn-outline-secondary" type="button">Mostrar todas consultas</button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="filtro-hora">Filtrar por horário:</label>
                            <input type="text" id="filtro-hora" class="form-control" placeholder="Insira o horário">
                        </div>
                    </div>
                    <table id="consultas-table" class="table">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Tipo de Consulta</th>
                                <th>Profissional</th>
                                <th>Dia Marcado</th>
                                <th>Dia de Atendimento</th>
                                <th>Hora</th>
                                <th>Duração</th>
                                <!-- <th>Descrição</th> -->
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>


@push('scripts')
<script>
    let table;

    $(document).ready(function() {
        const $select = $('#paciente_id');
        $select.select2({
            theme: "bootstrap-5",
            minimumInputLength: 3, // Defina o número mínimo de caracteres para 1
            placeholder: "Selecione o paciente",
            language: {
                inputTooShort: function() {
                    return "Digite o nome ou CPF";
                }
            },
            ajax: {
                url: "{{ route('pacientes.buscar') }}",
                type: "post",
                dataType: 'json',
                data: function(params) {
                    return {
                        nome: params.term,
                        cpf: params.term,
                        "_token": "{{ csrf_token() }}",
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.nome,
                                cpf: item.cpf
                            }
                        })
                    };
                },
            },
            templateResult: function(result) {
                if (!result.cpf) {
                    return result.text;
                }
                return $('<span>').html(result.text + ' - CPF: <strong>' + result.cpf + '</strong>');
            },

        })
    });
    // Ocultar o cabeçalho da tabela por padrão
    $('#consultas-table thead').hide();
    // Esconder rótulo e input de filtro por data
    $('label[for="filtro-data"], #filtro-data, #limpar-filtro-data').hide();
    // Esconder rótulo e input de filtro por horário
    $('label[for="filtro-hora"], #filtro-hora').hide();

    $(document).ready(function() {
        const $select = $('#profissional_id');
        $select.select2({
            theme: "bootstrap-5",
            minimumInputLength: 1, // Defina o número mínimo de caracteres para 3
            placeholder: "Selecione o profissional",
            language: {
                inputTooShort: function() {
                    return "Digite o nome";
                },
                errorLoading: function() {
                    return "Selecione o dia da consulta para buscar o profissional";
                },
            },
            ajax: {
                url: "{{ route('profissionais.buscar') }}",
                type: "post",
                dataType: 'json',
                data: function(params) {
                    var dataSelecionada = $('#dia_consulta').val();
                    var $diaConsulta = $('#dia_consulta');

                    $diaConsulta.toggleClass('is-invalid', !dataSelecionada);
                    $diaConsulta.siblings('.invalid-feedback').text(dataSelecionada ? "" : "Selecione o Dia da Consulta");

                    if (!dataSelecionada) {
                        return false; // Cancelar a chamada AJAX
                    }

                    return {

                        nome: params.term,
                        data: $('#dia_consulta').val(),

                        "_token": "{{ csrf_token() }}",
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.nome,
                                num_consultas: item.num_consultas,
                                data_selecionada: item.data_selecionada // Obter a data selecionada do objeto retornado
                            }
                        })
                    };
                },
            },
            templateResult: function(result) {
                if (!result.id) {
                    return result.text;
                }

                var $result = $('<span></span>');
                $result.text(result.text);

                if (result.num_consultas) {
                    var $count = $('<span class="count"></span>');
                    $count.text(' (possui ' + result.num_consultas + ' consulta' + (result.num_consultas !== 1 ? 's' : '') + ' no dia ' + result.data_selecionada + ')');
                    $result.append($count);
                }
                return $result;
            }
        })

        $select.on('select2:select', function(e) {
            var profissionalId = e.params.data.id;
            // Chame a função para carregar as consultas do profissional selecionado
            carregarConsultas(profissionalId);

        });

        function carregarConsultas(profissionalId) {
            if (table && $.fn.DataTable.isDataTable('#consultas-table')) {
                table.destroy(); // Destrua a instância existente da tabela, se houver
            }
            // Adicionando DataTables
            table = new DataTable('#consultas-table', {
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json",
                    "processing": "",
                },
                ajax: {
                    url: "{{ route('profissional.buscarConsulta') }}",
                    method: 'GET',
                    data: function(d) {
                        // Adicione o parâmetro profissionalId à solicitação
                        d.profissionalId = profissionalId;
                        let filtroData = $('#dia_consulta').val();
                        if (filtroData) {
                            d.data = filtroData;
                        }
                    },
                },
                processing: true,
                serverSide: true,
                searching: true,
                autoWidth: false, // Desabilita a largura automática das colunas
                responsive: true, // Habilita a funcionalidade responsiva
                scrollX: true, // Adicione esta opção para permitir rolagem horizontal
                columns: [{
                        data: 'paciente.nome',
                        name: 'paciente.nome',
                        render: function(data, type, row) {
                            var nomePartes = data.split(' ');
                            var primeiroNome = nomePartes[0];
                            var segundoNome = nomePartes[1] || '';
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
                                    duracaoFormatada = `${horas} hora${horas > 1 ? 's' : ''}`;
                                }

                                if (minutos > 0) {
                                    duracaoFormatada += `${duracaoFormatada !== '' ? ' ' : ''}${minutos} minuto${minutos > 1 ? 's' : ''}`;
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
                                <select class="form-control status-select" data-id="${row.id}" disabled>
                                    ${selectOptions}
                                </select>
                                </div>
                            `;
                            return selectHtml;
                        },
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
                    $('#dia_consulta').on('change', function() {
                        table.column(4).search(this.value).draw();
                    });

                    // Filtro por hora de atendimento
                    $('#filtro-hora').on('keyup', function() {
                        table.column(5).search(this.value).draw();
                    });
                },
                drawCallback: function() {
                    // Mostrar o cabeçalho da tabela após o carregamento dos dados
                    $('#consultas-table thead').show();
                    $('label[for="filtro-data"], #filtro-data, #limpar-filtro-data').show();
                    $('label[for="filtro-hora"], #filtro-hora').show();
                }

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
                $('#dia_consulta').val('');
                table.search('').columns().search('').draw();
            });

        }
    });

    $(document).ready(function() {
        $('#tipo_consulta_id').select2({
            theme: "bootstrap-5",
            placeholder: "Selecione o tipo da consulta",
            language: "pt-BR" // Defina o idioma como "pt-BR" para português do Brasil
        });
    });
</script>
@endpush