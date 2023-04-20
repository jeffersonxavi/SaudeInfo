<div class="form-row">
    <div class="form-group col-md-6">
        <label for="nome">Nome completo:</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ $paciente->nome ?? old('nome') }}" required>
    </div>

    <div class="form-group col-md-3">
        <label for="cpf">CPF:</label>
        <input type="text" class="form-control" id="cpf" name="cpf" value="{{ $paciente->cpf ?? old('cpf') }}" required>
    </div>

    <div class="form-group col-md-3">
        <label for="rg">RG:</label>
        <input type="text" class="form-control" id="rg" name="rg" value="{{ $paciente->rg ?? old('rg') }}">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-5">
        <label for="telefone">Telefone:</label>
        <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $paciente->telefone ?? old('telefone') }}" required>
    </div>

    <div class="form-group col-md-7">
        <label for="email">E-mail:</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $paciente->email ?? old('email') }}" required>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-2">
        <label for="cep">CEP</label>
        <input type="text" class="form-control" id="cep" name="cep" value="{{ $paciente->cep ?? old('cep') }}" required>
    </div>

    <div class="form-group col-md-1">
        <label for="uf">UF</label>
        <input type="text" class="form-control" id="uf" name="uf" value="{{ $paciente->uf ?? old('uf') }}" required>
    </div>
    <div class="form-group col-md-4">
        <label for="cidade">Cidade</label>
        <input type="text" class="form-control" id="cidade" name="cidade" value="{{ $paciente->cidade ?? old('cidade') }}" required>
    </div>
    

    <div class="form-group col-md-5">
        <label for="endereco">Endereço</label>
        <input type="text" class="form-control" id="endereco" name="endereco" value="{{ $paciente->endereco ?? old('endereco') }}" required>
    </div>
</div>

<div class="form-row">


    <div class="form-group col-md-4">
        <label for="bairro">Bairro</label>
        <input type="text" class="form-control" id="bairro" name="bairro" value="{{ $paciente->bairro ?? old('bairro') }}" required>
    </div>

    <div class="form-group col-md-2">
        <label for="numero">Número</label>
        <input type="text" class="form-control" id="numero" name="numero" value="{{ $paciente->numero ?? old('numero') }}" required>
    </div>

    <div class="form-group col-md-6">
        <label for="complemento">Complemento</label>
        <input type="text" class="form-control" id="complemento" name="complemento" value="{{ $paciente->complemento ?? old('complemento') }}">
    </div>

</div>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="descricao">Observações</label>
        <textarea class="form-control" id="descricao" name="descricao" rows="3">{{ $paciente->descricao ?? old('descricao') }}</textarea>
    </div>
</div>