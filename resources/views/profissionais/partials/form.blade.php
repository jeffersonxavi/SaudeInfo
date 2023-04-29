<div class="form-row">
    <div class="form-group col-md-6">
        <label for="nome">Nome completo:</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ $profissional->nome ?? old('nome') }}" required>
    </div>
    <div class="form-group col-md-3">
        <label for="crm">CRM:</label>
        <input type="text" class="form-control" id="crm" name="crm" value="{{ $profissional->crm ?? old('crm') }}" required>
    </div>

    <div class="form-group col-md-3">
        <label for="cpf">CPF:</label>
        <input type="text" class="form-control" id="cpf" name="cpf" value="{{ $profissional->cpf ?? old('cpf') }}" required>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-5">
        <label for="telefone">Telefone:</label>
        <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $profissional->telefone ?? old('telefone') }}" required>
    </div>
    <div class="form-group col-md-6">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $profissional->email ?? old('email') }}" required>
    </div>
    <div class="form-group col-md-3">
        <label for="senha">Senha:</label>
        <input type="password" class="form-control" id="senha" name="senha" value="{{ $profissional->senha ?? old('senha') }}" required>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-2">
        <label for="cep">CEP</label>
        <input type="text" class="form-control" id="cep" name="cep" value="{{ $profissional->cep ?? old('cep') }}" required>
    </div>

    <div class="form-group col-md-1">
        <label for="uf">UF</label>
        <input type="text" class="form-control" id="uf" name="uf" value="{{ $profissional->uf ?? old('uf') }}" required>
    </div>
    <div class="form-group col-md-4">
        <label for="cidade">Cidade</label>
        <input type="text" class="form-control" id="cidade" name="cidade" value="{{ $profissional->cidade ?? old('cidade') }}" required>
    </div>


    <div class="form-group col-md-5">
        <label for="endereco">Endereço</label>
        <input type="text" class="form-control" id="endereco" name="endereco" value="{{ $profissional->endereco ?? old('endereco') }}" required>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="bairro">Bairro</label>
        <input type="text" class="form-control" id="bairro" name="bairro" value="{{ $profissional->bairro ?? old('bairro') }}" required>
    </div>

    <div class="form-group col-md-2">
        <label for="numero">Número</label>
        <input type="text" class="form-control" id="numero" name="numero" value="{{ $profissional->numero ?? old('numero') }}" required>
    </div>

    <div class="form-group col-md-6">
        <label for="complemento">Complemento</label>
        <input type="text" class="form-control" id="complemento" name="complemento" value="{{ $profissional->complemento ?? old('complemento') }}">
    </div>
</div>