@extends('layouts.app')

@section('content')
<style>
    .bg-gradient-green {
        background-image: linear-gradient(to right, #00bfa5, #1de9b6);
    }

    .bg-gradient-blue {
        background-image: linear-gradient(to right, #2962ff, #00b0ff);
    }

    .bg-gradient-orange {
        background-image: linear-gradient(to right, #ff9100, #ffc400);
    }

    /* Media Screen */
    @media only screen and (max-width: 600px) {
        .info article {
            margin-bottom: 20px;
        }
    }

    /* Info */
    .info {
        padding: 20px 0;
    }

    .info article {
        padding: 20px;
        border-radius: 10px;
    }

    .info article i {
        color: #fff;
        font-size: 2.5rem;
    }

    .info article p {
        color: #fff;
        font-size: 0.9rem;
        text-transform: uppercase;
        margin: 0;
    }

    .info article h3 {
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        text-transform: uppercase;
        margin: 0 0 20px 0;
    }

    /* Gráficos */
    .graficos {
        padding: 20px;
    }

    .grafico {
        padding: 20px;
        border-radius: 10px;
    }

    .grafico h5 {
        font-size: 1rem;
        text-transform: uppercase;
        font-weight: 500;
        color: #333;
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
</style>


@can('user')
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
        <div class="card bg-white rounded-lg shadow-sm custom-card">
            <div class="card-body d-flex align-items-center">
                <div class="p-3 mr-4 custom-circle">
                    <i class="fa-solid fa-bell"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-weight-medium text-gray-600">Média de Consultas</p>
                    <p class="text-lg font-weight-bold text-gray-700">
                        <span class="average-label"><strong>{{ number_format($mediaConsultasPaciente, 2) }}</strong></span>
                        <span class="average-label"><strong>{{ number_format($mediaConsultasProfissional, 2) }}</strong></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-white rounded-lg shadow-sm custom-card align-items-stretch">
            <div class="card-footer text-center" style="background-color:#333;">
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


    <div class="col-md-2">
        <div class="card bg-white rounded-lg shadow-sm custom-card">
            <div class="card-body d-flex align-items-center">
                <div class="p-3 mr-4 custom-circle" style="background-color: white;">
                    <i class="fa-solid fa-bell" style="color:#00bfa5"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-weight-medium text-gray-600">Avisos</p>
                    <p class="text-lg font-weight-bold text-gray-700">{{number_format($mediaConsultasProfissional, 2)}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-white rounded-lg shadow-sm custom-card custom-height" style="height: 320px; margin:auto;">
            <span class="card-title black-text text-center">Próximas consultas</span>
            <div class="table-responsive">
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col">Paciente</th>
                            <th scope="col">Consulta</th>
                            <th scope="col">Profissional</th>
                            <th scope="col">Horário</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proximas_consultas as $prox_consulta)
                        <tr>
                            <td>{{ implode(' ', array_slice(explode(' ', $prox_consulta->paciente->nome), 0, 2)) }}</td>
                            <td>{{$prox_consulta->tipoConsulta->nome ?? ''}}</td>
                            <td>{{ implode(' ', array_slice(explode(' ', $prox_consulta->profissional->nome), 0, 2)) }}</td>
                            <td>{{$prox_consulta->hora_consulta}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card bg-white rounded-lg shadow-sm custom-card custom-height" style="height: 320px; margin:auto;">
            <canvas id="chart"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm ">
            <div class="card-content">
                <canvas style="width: 354px; margin:auto;" id="pieChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-gradient-green rounded-lg shadow-sm custom-card">
            <div class="card-content"style="height: 400px;">
                <span class="card-title white-text">Avisos</span>
                <table class="striped">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Idade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>João</td>
                            <td>30</td>
                        </tr>
                        <tr>
                            <td>Maria</td>
                            <td>25</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@elsecan('admin')
Sistema para o projeto de TCC - Somente ADMIN vai
@endcan
@endsection

@push('scripts')
<!-- Compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var ctx = document.getElementById('chart').getContext('2d');
    var userChart = new Chart(ctx, {
        type: 'line',
        data: JSON.parse('@json($graficoConsultaMes)'),
        options: chartOptions
    });


    // Renderizar o gráfico
    var pieChart = new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: JSON.parse('@json($graficoTipoConsulta)'),
        options: chartOptions
    });

    // Configuração do gráfico
    var chartOptions = {
        responsive: true,
        legend: {
            position: 'bottom',
            labels: {
                boxWidth: 12
            }
        }
    };
</script>
@endpush