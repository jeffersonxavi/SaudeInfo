@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Cadastro de Agenda Profissinal</h4>
                    <a href="{{ route('agendas.index') }}" class="btn btn-outline-secondary btn-sm text-white">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
            <div class="tab-content">
                <form method="POST" action="{{ route('agendas.store') }}">
                    @csrf
                    @include('agenda_profissionais.partials.form')
                    <div class="form-group row">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" style="color:black" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection