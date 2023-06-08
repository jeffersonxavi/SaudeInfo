<div class="form-row">
    <div class="form-group col-md-5">
        <label for="titulo">Título:</label>
        <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $aviso->titulo ?? old('titulo') }}" required>
    </div>
    <div class="form-group col-md-3">
        <label for="data_aviso">Dia do evento:</label>
        <input type="date" class="form-control" id="data_aviso" name="data_aviso" value="{{ $aviso->data_aviso ?? old('data_aviso') }}">
    </div>  
    <div class="form-group col-md-4">
        <label for="periodo_exibicao">Período de Exibição:</label>
        <div class="input-group">
            <input type="date" class="form-control" id="data_criacao" name="data_criacao" value="{{ $aviso->data_criacao ?? old('data_criacao') }}" required>
            <div class="input-group-prepend">
                <span class="input-group-text" style="height:34px">até</i></span>
            </div>
            <input type="date" class="form-control" id="data_expiracao" name="data_expiracao" value="{{ $aviso->data_expiracao ?? old('data_expiracao') }}">
        </div>
    </div>
</div>



<div class="form-row">
    <div class="form-group col-md-4">
        <label for="prioridade">Prioridade:</label>
        <select class="form-control" id="prioridade" name="prioridade" required>
            <option value="alta" {{ (isset($aviso) && $aviso->prioridade == 'alta') ? 'selected' : '' }}>Alta</option>
            <option value="media" {{ (isset($aviso) && $aviso->prioridade == 'media') ? 'selected' : '' }}>Média</option>
            <option value="baixa" {{ (isset($aviso) && $aviso->prioridade == 'baixa') ? 'selected' : '' }}>Baixa</option>
        </select>
    </div>
    <div class="form-group col-md-4">
        <label for="estado">Estado:</label>
        <select class="form-control" id="estado" name="estado" required>
            <option value="pendente" {{ (isset($aviso) && $aviso->estado == 'pendente') ? 'selected' : '' }}>Pendente</option>
            <option value="em_andamento" {{ (isset($aviso) && $aviso->estado == 'em_andamento') ? 'selected' : '' }}>Em Andamento</option>
            <option value="concluido" {{ (isset($aviso) && $aviso->estado == 'concluido') ? 'selected' : '' }}>Concluído</option>
        </select>
    </div>
    <div class="form-group col-md-4">
        <label for="responsavel">Responsável:</label>
        <input type="text" class="form-control" id="responsavel" name="responsavel" value="{{ $aviso->responsavel ?? old('responsavel') }}" required>
    </div>
</div>


<div class="form-row">
    <div class="form-group col-md-12">
        <label for="descricao">Descrição</label>
        <textarea class="form-control" id="descricao" name="descricao" rows="3">{{ $aviso->descricao ?? old('descricao') }}</textarea>
    </div>
</div>