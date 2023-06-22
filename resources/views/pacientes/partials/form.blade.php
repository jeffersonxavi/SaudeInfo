<div class="form-row">
    <div class="form-group col-md-4">
        <label for="nome">Nome completo:</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ $paciente->nome ?? old('nome') }}" required>
        @error('nome')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-2">
        <label for="cpf">CPF:</label>
        <input type="text" class="form-control" id="cpf" name="cpf" value="{{ $paciente->cpf ?? old('cpf') }}" required>
        @error('cpf')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group col-md-2">
        <label for="rg">RG:</label>
        <input type="text" class="form-control" id="rg" name="rg" value="{{ $paciente->rg ?? old('rg') }}">
        @error('rg')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-2">
        <label for="numero_sus">Número SUS:</label>
        <input type="text" class="form-control" id="numero_sus" name="numero_sus" value="{{ $paciente->numero_sus ?? old('numero_sus') }}" required>
        @error('numero_sus')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group col-md-2">
        <label for="genero">Gênero:</label>
        <select class="form-control" id="genero" name="genero" required>
            <option value="masculino" {{ (isset($paciente) && $paciente->genero == 'masculino') ? 'selected' : '' }}>Masculino</option>
            <option value="feminino" {{ (isset($paciente) && $paciente->genero == 'feminino') ? 'selected' : '' }}>Feminino</option>
            <option value="outro" {{ (isset($paciente) && $paciente->genero == 'outro') ? 'selected' : '' }}>Outro</option>
        </select>
        @error('genero')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group col-md-2">
        <label for="estado_civil">Estado Civil:</label>
        <select class="form-control" id="estado_civil" name="estado_civil" required>
            <option value="solteiro" {{ (isset($paciente) && $paciente->estado_civil == 'solteiro') ? 'selected' : '' }}>Solteiro(a)</option>
            <option value="casado" {{ (isset($paciente) && $paciente->estado_civil == 'casado') ? 'selected' : '' }}>Casado(a)</option>
            <option value="divorciado" {{ (isset($paciente) && $paciente->estado_civil == 'divorciado') ? 'selected' : '' }}>Divorciado(a)</option>
            <option value="viuvo" {{ (isset($paciente) && $paciente->estado_civil == 'viuvo') ? 'selected' : '' }}>Viúvo(a)</option>
            <option value="outro" {{ (isset($paciente) && $paciente->estado_civil == 'outro') ? 'selected' : '' }}>Outro</option>
        </select>
        @error('estado_civil')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group col-md-2">
        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ $paciente->data_nascimento ?? old('data_nascimento') }}" required>
        @error('data_nascimento')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-2">
        <label for="telefone">Telefone:</label>
        <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $paciente->telefone ?? old('telefone') }}" required>
        @error('telefone')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-4">
        <label for="email" class="required-label">E-mail<span class="required-asterisk">*</span></label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email ?? old('email') }}" required @if(empty($paciente)) data-toggle="tooltip" data-placement="top" title="Preencher os campos marcados com * resultará na criação de uma nova conta para o paciente." @endif>
        @error('email')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-2">
        <label for="senha" class="required-label">Senha<span class="required-asterisk">*</span></label>
        <input type="password" class="form-control" id="senha" name="senha" value="{{ $paciente->senha ?? old('senha') }}" required>
        @error('senha')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-2">
        <label for="cep">CEP</label>
        <input type="text" class="form-control" id="cep" name="cep" value="{{ $paciente->cep ?? old('cep') }}" required>
        @error('cep')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group col-md-1">
        <label for="uf">UF</label>
        <input type="text" class="form-control" id="uf" name="uf" value="{{ $paciente->uf ?? old('uf') }}" required>
        @error('uf')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-4">
        <label for="cidade">Cidade</label>
        <input type="text" class="form-control" id="cidade" name="cidade" value="{{ $paciente->cidade ?? old('cidade') }}" required>
        @error('cidade')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group col-md-5">
        <label for="endereco">Endereço</label>
        <input type="text" class="form-control" id="endereco" name="endereco" value="{{ $paciente->endereco ?? old('endereco') }}" required>
        @error('endereco')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-row">


    <div class="form-group col-md-4">
        <label for="bairro">Bairro</label>
        <input type="text" class="form-control" id="bairro" name="bairro" value="{{ $paciente->bairro ?? old('bairro') }}" required>
        @error('bairro')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group col-md-2">
        <label for="numero">Número</label>
        <input type="text" class="form-control" id="numero" name="numero" value="{{ $paciente->numero ?? old('numero') }}" required>
        @error('numero')
        <div class="text-danger">{{ $message }}</div>
        @enderror
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
@push('scripts')
<script>
    $(document).ready(function() {

        // Máscara para o campo CPF
        $('#cpf').inputmask('999.999.999-99');

        $('#rg').inputmask('99.999.999-99');

        $('#numero_sus').inputmask('999 9999 9999 9999');

        $('#telefone').inputmask('(99) 99999-9999');

        $('#cep').inputmask('99999-999');

        $('#uf').inputmask('AA');

        $('#numero').inputmask('999999');

    });
    $(document).on('blur', '#cep', function() {
        const cep = $(this).val();
        $.ajax({
            url: 'https://viacep.com.br/ws/' + cep + '/json/',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#uf').val(data.uf);
                $('#cidade').val(data.localidade);
                $('#complemento').val(data.complemento);
                $('#endereco').val(data.logradouro);
                $('#bairro').val(data.bairro);
            }
        });
    });

    //  FUNÇÃO DE MASCARA MAIUSCULA
    $('#nome').on('input', function() {
        var nome = $(this).val();
        $(this).val(nome.toUpperCase());
    });
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush