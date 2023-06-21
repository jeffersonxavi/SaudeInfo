<div class="card">
    <div class="card-header d-flex justify-content-between">
    <span>Laudo - {{$consulta->paciente->nome}}</span>

        <a href="{{ route('gerar.pdf', $consulta->id) }}" target="_blank" class="btn btn-sm btn-danger text-white ml-auto">
            <i class="far fa-file-pdf"></i> Exportar Laudo em PDF
        </a>
    </div>
    <div class="card-body"> 
        <form action="{{ route('laudos.store') }}" method="POST" id="createLaudoForm">
            @csrf
            <input type="hidden" name="consulta_id" id="consulta_id" value="{{$consulta->id ?? ''}}">
            <input type="hidden" name="tipo_consulta_id" id="tipo_consulta_id" value="{{$consulta->tipoConsulta->id ?? ''}}">
            <input type="hidden" name="profissional_id" id="profissional_id" value="{{$consulta->profissional->id ?? ''}}">
            <input type="hidden" name="paciente_id" id="paciente_id" value="{{$consulta->paciente->id ?? ''}}">
            <input type="hidden" name="data" id="data" value="{{date('Y-m-d')}}">
            <div class="form-group">
                <label for="tipo_consulta_id">Tipo de Consulta:</label>
                <span id="tipo_consulta_id" name="tipo_consulta_id" value="{{$consulta->tipoConsulta->id ?? ''}}">{{$consulta->tipoConsulta->nome ?? ''}}</span>
            </div>

            <div class="form-group">
                <label for="profissional_id">Profissional:</label>
                <span id="profissional_id" name="profissional_id" value="{{$consulta->profissional->id ?? ''}}">{{$consulta->profissional->nome ?? ''}}</span>
            </div>
            <div class="form-group">
                <label for="paciente_id">Paciente:</label>
                <span id="paciente_id" name="paciente_id" value="{{$consulta->paciente->id ?? ''}}">{{$consulta->paciente->nome ?? ''}}</span>
            </div>
            <div class="form-group">
                <label for="motivo_consulta">Motivo da Consulta:</label>
                <textarea name="motivo_consulta" id="motivo_consulta" class="form-control" rows="2" required>{{ $laudo->motivo_consulta ?? '' }}</textarea>
                @error('motivo_consulta')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="diagnostico">Diagnóstico:</label>
                <textarea name="diagnostico" id="summernote_diagnostico" cols="30" rows="10" value="{{$laudo->diagnostico ?? ''}}">{{$laudo->diagnostico ?? ''}}</textarea>
            </div>
            <div class="form-group">
                <label for="tratamento_recomendado">Tratamento:</label>
                <textarea name="tratamento_recomendado" id="summernote_tratamento" cols="30" rows="10" value="{{$laudo->tratamento_recomendado ?? ''}}">{{$laudo->tratamento_recomendado ?? ''}}</textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Salvar Laudo</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
<script>

    $(document).ready(function() {
        $('#summernote_diagnostico').summernote({
            height: 350, // Defina a altura desejada do editor
            placeholder: 'Exemplo: Fratura óssea constatada no exame radiológico',
        });
        $('#summernote_tratamento').summernote({
            height: 120, // Defina a altura desejada do editor
            placeholder: 'Exemplo: Prescrição do medicamento X, a ser tomado duas vezes ao dia após as refeições.'
        });
    });
</script>
@endpush