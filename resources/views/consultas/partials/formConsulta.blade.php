<div class="card">
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
                <label for="conteudo">Conteúdo:</label>
                <textarea name="conteudo" id="summernote" value="{{$laudo->conteudo ?? ''}}" cols="30" rows="10" required>{{$laudo->conteudo ?? ''}}</textarea>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Salvar Laudo</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 200 // Defina a altura desejada do editor
        });
    });
</script>
@endpush