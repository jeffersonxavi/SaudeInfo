@extends('layouts.app')

@section('content')
<style>
    .bg-gradient-lightgreen {
        background-image: linear-gradient(to right, #c1e7d9, #93d9c6);
    }

    .sidebar nav a i {
        font-size: 20px;
        margin-right: 10px;
        height: auto;
        width: auto;
        line-height: 20px;
    }

    ul.submenu li {
        width: 100%;
    }

    .custom-circle {
        width: 50px;
        height: 50px;
        background-color: #000;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .custom-circle i {
        color: #FFC107;
        font-size: 24px;
    }

    .custom-card p {
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 500;
        color: #808080;
    }

    .custom-card p:last-child {
        font-size: 18px;
        font-weight: bold;
        color: #333333;
    }

    .custom-height {
        height: 326px;

        /* Defina a altura da tabela */
    }

    .agenda {
        margin-top: 20px;
    }

    .evento {
        display: flex;
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
    }

    .evento-content {
        flex: 1;
    }

    .evento-titulo {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 5px;
    }

    .evento-descricao {
        margin-top: 5px;
        margin-bottom: 10px;

    }

    .evento-data {
        display: flex;
        align-items: flex-start;
        margin-top: 5px;
    }

    .agenda-date {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .agenda-date .day {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .agenda-date .month {
        font-size: 14px;
        color: #666;
    }

    .evento-responsavel {
        font-size: 14px;
        color: #666;
        font-style: italic;

    }

    .custom-title {
        background-color: #008f7c;
        color: white;
        padding: 10px;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
        font-weight: bold;
    }

    .custom-evento {
        background-color: #F8F8F8;
        border-left: 4px solid #FF6F61;
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>


@can('admin')
<!-- Cards -->
<div class="row">
    <div class="col-md-3">
        <div class="card bg-white rounded-lg shadow-sm custom-card">
            <div class="card-body d-flex align-items-center">
                <div class="p-3 mr-4 custom-circle">
                    <i class="fas fa-user-md" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-weight-medium text-gray-600">Total de Profissionais</p>
                    <p class="text-lg font-weight-bold text-gray-700">{{$total_profissionais}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-white rounded-lg shadow-sm custom-card">
            <div class="card-body d-flex align-items-center">
                <div class="p-3 mr-4 custom-circle">
                    <i class="fas fa-procedures" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-weight-medium text-gray-600">Total de Pacientes</p>
                    <p class="text-lg font-weight-bold text-gray-700">{{$total_pacientes}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-white rounded-lg shadow-sm custom-card">
            <div class="card-body d-flex align-items-center">
                <div class="p-3 mr-4 custom-circle">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-weight-medium text-gray-600">Total de consultas</p>
                    <p class="text-lg font-weight-bold text-gray-700">{{$total_consultas}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-white rounded-lg shadow-sm custom-card">
            <div class="card-body d-flex align-items-center">
                <div class="p-3 mr-4 custom-circle">
                    <i class="fas fa-clipboard-list" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-weight-medium text-gray-600">Consultas hoje</p>
                    <p class="text-lg font-weight-bold text-gray-700">{{$consultas_do_dia}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-white rounded-lg shadow-sm custom-card align-items-stretch">
            <div class="card-footer text-center" style="background-color:#008f7c;">
                <small class="text-white" class="text-white">Média de consultas</small>
                <!-- <small class="text-muted"></small> -->
            </div>
            <div class="card-body d-flex align-items-center justify-content-center text-center">
                <div class="media-average">
                    <span class="average-label mr-2">
                        <i class="fas fa-user" aria-hidden="true"></i> Paciente:
                        <strong>{{ number_format($mediaConsultasPaciente, 2) }}</strong>
                    </span>
                    <span class="average-label">
                        <i class="fas fa-user-md" aria-hidden="true"></i> Profissional:
                        <strong>{{ number_format($mediaConsultasProfissional, 2) }}</strong>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-white rounded-lg shadow-sm custom-card align-items-stretch">
            <div class="card-body d-flex align-items-center justify-content-center text-center">
                <canvas style="height: 60px; width: 600px;" id="barChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-white rounded-lg shadow-sm custom-card">
            <div class="card-body d-flex align-items-center">
                <div class="p-3 mr-4 custom-circle" style="background-color: white;">
                    <i class="fa-solid fa-bell" style="color:#00bfa5"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-weight-medium text-gray-600">Avisos</p>
                    <p class="text-lg font-weight-bold text-gray-700">{{$total_avisos}}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-md-6">
        <div class="card bg-white rounded-lg shadow-sm custom-card custom-height" style="height: 360px; padding:20px"> -->
    <div class="col-md-6">
        <div class="card bg-white rounded-lg shadow-sm custom-card border-0" style="height: 360px;">
            <span class="card-title white-text text-center custom-title">Agenda</span>
            <div class="table-responsive">
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Horário</th>
                            <th scope="col">Paciente</th>
                            <th scope="col">Profissional</th>
                            <th scope="col">Consulta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proximas_consultas as $prox_consulta)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($prox_consulta->dia_consulta)->format('d/m/Y') }}</td>
                            <td>{{$prox_consulta->hora_consulta}}</td>
                            <td>{{ implode(' ', array_slice(explode(' ', $prox_consulta->paciente->nome), 0, 2)) }}</td>
                            <td>{{ implode(' ', array_slice(explode(' ', $prox_consulta->profissional->nome), 0, 2)) }}</td>
                            <td>{{$prox_consulta->tipoConsulta->nome ?? ''}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-white rounded-lg shadow-sm custom-card border-0">
            <!-- <div class="card-content"> -->
            <span class="card-title custom-title">Avisos</span>
            <div class="agenda">
                @if ($avisos->isEmpty())
                <div class="no-avisos">Não há avisos disponíveis.</div>
                @else
                @foreach($avisos as $aviso)
                <div class="evento custom-evento">
                    <div class="evento-content">
                        <div class="evento-titulo">
                            <i class="fa-solid fa-bell"></i> {{$aviso->titulo}}
                        </div>
                        <div class="evento-descricao">{{$aviso->descricao}}</div>
                        <div class="evento-responsavel">Responsável: {{$aviso->responsavel ?? 'Sem identificação'}}</div>
                    </div>
                    <div class="evento-data">
                        <div class="agenda-date">
                            <span class="day">{{ date('d', strtotime($aviso->data_aviso)) }}</span>
                            <span class="month">{{ date('M', strtotime($aviso->data_aviso)) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@elsecan('profissional')
<!-- Cards -->
<div class="row">
    <div class="col-md-3">
        <div class="card bg-white rounded-lg shadow-sm custom-card">
            <div class="card-body d-flex align-items-center">
                <div class="p-3 mr-4 custom-circle">
                    <i class="fas fa-procedures" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-weight-medium text-gray-600">Total de Pacientes</p>
                    <p class="text-lg font-weight-bold text-gray-700">{{$total_pacientes_profissional}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-white rounded-lg shadow-sm custom-card">
            <div class="card-body d-flex align-items-center">
                <div class="p-3 mr-4 custom-circle">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-weight-medium text-gray-600">Total de consultas</p>
                    <p class="text-lg font-weight-bold text-gray-700">{{$total_consultas}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-white rounded-lg shadow-sm custom-card">
            <div class="card-body d-flex align-items-center">
                <div class="p-3 mr-4 custom-circle">
                    <i class="fas fa-clipboard-list" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-weight-medium text-gray-600">Consultas hoje</p>
                    <p class="text-lg font-weight-bold text-gray-700">{{$consultas_do_dia}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-white rounded-lg shadow-sm custom-card align-items-stretch">
            <div class="card-footer text-center" style="background-color:#008f7c;">
                <small class="text-white" class="text-white">Média de consultas</small>
                <!-- <small class="text-muted"></small> -->
            </div>
            <div class="card-body d-flex align-items-center justify-content-center text-center">
                <div class="media-average">
                    <span class="average-label mr-2">
                        <i class="fas fa-user" aria-hidden="true"></i> Paciente:
                        <strong>{{ number_format($mediaConsultasPaciente, 2) }}</strong>
                    </span>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-white rounded-lg shadow-sm custom-card align-items-stretch">
            <div class="card-body d-flex align-items-center justify-content-center text-center">
                <canvas style="height: 60px; width: 600px;" id="barChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-white rounded-lg shadow-sm custom-card">
            <div class="card-body d-flex align-items-center">
                <div class="p-3 mr-4 custom-circle" style="background-color: white;">
                    <i class="fa-solid fa-bell" style="color:#00bfa5"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-weight-medium text-gray-600">Avisos</p>
                    <p class="text-lg font-weight-bold text-gray-700">{{$total_avisos}}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-md-6">
        <div class="card bg-white rounded-lg shadow-sm custom-card custom-height" style="height: 360px; padding:20px"> -->
    <div class="col-md-6">
        <div class="card bg-white rounded-lg shadow-sm custom-card border-0" style="height: 360px;">
            <span class="card-title white-text text-center custom-title">Agenda</span>
            <div class="table-responsive">
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Horário</th>
                            <th scope="col">Paciente</th>
                            <th scope="col">Profissional</th>
                            <th scope="col">Consulta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proximas_consultas as $prox_consulta)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($prox_consulta->dia_consulta)->format('d/m/Y') }}</td>
                            <td>{{$prox_consulta->hora_consulta}}</td>
                            <td>{{ implode(' ', array_slice(explode(' ', $prox_consulta->paciente->nome), 0, 2)) }}</td>
                            <td>{{ implode(' ', array_slice(explode(' ', $prox_consulta->profissional->nome), 0, 2)) }}</td>
                            <td>{{$prox_consulta->tipoConsulta->nome ?? ''}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-white rounded-lg shadow-sm custom-card border-0">
            <!-- <div class="card-content"> -->
            <span class="card-title custom-title">Avisos</span>
            <div class="agenda">
                @if ($avisos->isEmpty())
                <div class="no-avisos">Não há avisos disponíveis.</div>
                @else
                @foreach($avisos as $aviso)
                <div class="evento custom-evento">
                    <div class="evento-content">
                        <div class="evento-titulo">
                            <i class="fa-solid fa-bell"></i> {{$aviso->titulo}}
                        </div>
                        <div class="evento-descricao">{{$aviso->descricao}}</div>
                        <div class="evento-responsavel">Responsável: {{$aviso->responsavel ?? 'Sem identificação'}}</div>
                    </div>
                    <div class="evento-data">
                        <div class="agenda-date">
                            <span class="day">{{ date('d', strtotime($aviso->data_aviso)) }}</span>
                            <span class="month">{{ date('M', strtotime($aviso->data_aviso)) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@elsecan('user')
<!-- Cards -->
<div class="row">
    <div class="col-md-3">
        <div class="card bg-white rounded-lg shadow-sm custom-card">
            <div class="card-body d-flex align-items-center">
                <div class="p-3 mr-4 custom-circle">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-weight-medium text-gray-600">Total de consultas</p>
                    <p class="text-lg font-weight-bold text-gray-700">{{$total_consultas}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-white rounded-lg shadow-sm custom-card">
            <div class="card-body d-flex align-items-center">
                <div class="p-3 mr-4 custom-circle">
                    <i class="fas fa-clipboard-list" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-weight-medium text-gray-600">Consultas hoje</p>
                    <p class="text-lg font-weight-bold text-gray-700">{{$consultas_do_dia}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-white rounded-lg shadow-sm custom-card align-items-stretch">
            <div class="card-body d-flex align-items-center justify-content-center text-center">
                <canvas style="height: 60px; width: 600px;" id="barChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-white rounded-lg shadow-sm custom-card">
            <div class="card-body d-flex align-items-center">
                <div class="p-3 mr-4 custom-circle" style="background-color: white;">
                    <i class="fa-solid fa-bell" style="color:#00bfa5"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-weight-medium text-gray-600">Avisos</p>
                    <p class="text-lg font-weight-bold text-gray-700">{{$total_avisos}}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-md-6">
        <div class="card bg-white rounded-lg shadow-sm custom-card custom-height" style="height: 360px; padding:20px"> -->
    <div class="col-md-6">
        <div class="card bg-white rounded-lg shadow-sm custom-card border-0" style="height: 360px;">
            <span class="card-title white-text text-center custom-title">Agenda</span>
            <div class="table-responsive">
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Horário</th>
                            <th scope="col">Paciente</th>
                            <th scope="col">Profissional</th>
                            <th scope="col">Consulta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proximas_consultas as $prox_consulta)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($prox_consulta->dia_consulta)->format('d/m/Y') }}</td>
                            <td>{{$prox_consulta->hora_consulta}}</td>
                            <td>{{ implode(' ', array_slice(explode(' ', $prox_consulta->paciente->nome), 0, 2)) }}</td>
                            <td>{{ implode(' ', array_slice(explode(' ', $prox_consulta->profissional->nome), 0, 2)) }}</td>
                            <td>{{$prox_consulta->tipoConsulta->nome ?? ''}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-white rounded-lg shadow-sm custom-card border-0">
            <!-- <div class="card-content"> -->
            <span class="card-title custom-title">Avisos</span>
            <div class="agenda">
                @if ($avisos->isEmpty())
                <div class="no-avisos">Não há avisos disponíveis.</div>
                @else
                @foreach($avisos as $aviso)
                <div class="evento custom-evento">
                    <div class="evento-content">
                        <div class="evento-titulo">
                            <i class="fa-solid fa-bell"></i> {{$aviso->titulo}}
                        </div>
                        <div class="evento-descricao">{{$aviso->descricao}}</div>
                        <div class="evento-responsavel">Responsável: {{$aviso->responsavel ?? 'Sem identificação'}}</div>
                    </div>
                    <div class="evento-data">
                        <div class="agenda-date">
                            <span class="day">{{ date('d', strtotime($aviso->data_aviso)) }}</span>
                            <span class="month">{{ date('M', strtotime($aviso->data_aviso)) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endcan
@endsection

@push('scripts')
<!-- Compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Configuração do gráfico
    var chartOptions = {
        responsive: true,
        legend: {
            position: 'bottom',
            labels: {
                boxWidth: 12
            }
        },
        scales: {
            y: {
                display: true, // Oculta o eixo y
                ticks: {
                    display: true // Oculta as etiquetas no eixo y
                }
            },
            x: {
                display: false, // Oculta o eixo x
                ticks: {
                    display: false // Oculta as etiquetas no eixo x
                }
            }
        }
    };
    // Renderizar o gráfico
    var TipoConsultaChart = new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: JSON.parse('@json($graficoTipoConsulta)'),
        options: chartOptions
    });

    // var ctx = document.getElementById('chart').getContext('2d');
    // var userChart = new Chart(ctx, {
    //     type: 'line',
    //     data: JSON.parse('@json($graficoConsultaMes)'),
    //     options: {
    //         responsive: true,
    //     }
    // });
</script>
@endpush