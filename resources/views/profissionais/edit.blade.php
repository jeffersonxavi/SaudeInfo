@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Profissional / </h4>
                    <a href="{{ route('profissionais.index') }}" class="btn btn-outline-secondary btn-sm text-white">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab1">
                        <i class="fas fa-user"></i>
                        <span>Dados</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab2">
                        <i class="fas fa-users"></i>
                        <span>Pacientes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab3">
                        <i class="fas fa-stethoscope"></i>
                        <span>Especialidades</span>
                    </a>
                </li>
            </ul>
            <form id="form-profissional" method="POST" action="{{ route('profissionais.update', $profissional->id) }}">
                @csrf
                @method('PUT')
                <div class="tab-content mt-3">
                    <div id="tab1" class="tab-pane fade show active">
                        @include('profissionais.partials.form')
                    </div>
                    <div id="tab2" class="tab-pane fade">
                        @include('profissionais.partials.formPaciente')
                    </div>
                    <div id="tab3" class="tab-pane fade">
                        @include('profissionais.partials.formEspecialidade')
                    </div>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
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
        order: [
                [2, 'desc']
            ] // ordena pela coluna 'selecionar'
            ,
        columnDefs: [{
            targets: 2, // índice da coluna "Status"
            orderable: true // habilita a ordenação na coluna
        }],
        "select": true,
        "pageLength": 10,
        "searching": true,
        "pagingType": "full_numbers",
        "paginate": false

    });

    // Limpa a pesquisa
    $('#form-profissional').on('submit', function(event) {
        // Obtém a string de pesquisa atual da tabela
        var searchValue = table.search();
        // Verifica se a string de pesquisa não está vazia
        if (searchValue !== '') {
            // Se a pesquisa não estiver vazia, limpa a pesquisa e redesenha a tabela
            table.search('').draw();
        }
        // Retorna true para permitir o envio do formulário se a pesquisa estiver vazia, caso contrário retorna false
        return table.search() === '';
    });
</script>

@endpush