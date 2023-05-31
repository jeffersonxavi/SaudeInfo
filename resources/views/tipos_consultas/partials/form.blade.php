<div class="card">
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{ $tipoConsulta->nome ?? old('nome') }}" required>
            </div>
            <div class="form-group col-md-6">
                <label for="especialidade_id">Especialidade:</label>
                <select class="form-control select 2" id="especialidade_id" name="especialidade_id" required>
                    <option value="">Selecione o tipo de especialidade</option>
                    @foreach($especialidades as $especialidade)
                    <option value="{{ $especialidade->id }}" {{ isset($tipoConsulta) && $tipoConsulta->especialidade_id == $especialidade->id ? 'selected' : '' }}>{{ $especialidade->nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao">{{ $tipoConsulta->descricao ?? old('descricao') }}</textarea>
            </div>
            <div class="form-group col-md-2">
                <label for="duracao_estimada">Duração estimada (em min):</label>
                <input type="number" class="form-control" id="duracao_estimada" name="duracao_estimada" required value="{{ $tipoConsulta->duracao_estimada ?? old('duracao_estimada') }}">
            </div>
            <div class="form-group col-md-2">
                <label for="valor">Valor:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">R$</span>
                    </div>
                    <input type="number" class="form-control" id="valor" name="valor" value="{{ $tipoConsulta->valor ?? old('valor') }}">
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        $('#especialidade_id').select2({
            theme: "bootstrap-5",
            placeholder: "Selecione o tipo da nsulta",
            language: "pt-BR" // Defina o idioma como "pt-BR" para português do Brasil
        });
    });
</script>
@endpush