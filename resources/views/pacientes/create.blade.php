@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Cadastro de Paciente</h4>
                    <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary btn-sm text-white">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
            <div class="tab-content">
                <form method="POST" action="{{ route('pacientes.store') }}">
                    @csrf
                    @include('pacientes.partials.form')
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