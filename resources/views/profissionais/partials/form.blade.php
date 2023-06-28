<div class="form-row">
    <div class="form-group col-md-4">
        <label for="nome">Nome completo:</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ $user->name ?? old('nome') }}" required>
        @error('nome')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-2">
        <label for="cpf">CPF:</label>
        <input type="text" class="form-control" id="cpf" name="cpf" value="{{ $profissional->cpf ?? old('cpf') }}" required>
        @error('cpf')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-2">
        <label for="telefone">Telefone:</label>
        <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $profissional->telefone ?? old('telefone') }}">
        @error('telefone')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-4">
        <label for="tipo_profissional">Tipo de Profissional</label>
        <select id="tipo_profissional" name="tipo_profissional" class="form-control select2" @if(!empty($profissional->tipo_profissional)) @endif>
            <option value="" selected disabled>Escolha ou digite para adicionar</option>
            @foreach(['Médico', 'Enfermeiro', 'Psicólogo', 'Fisioterapeuta', 'Nutricionista'] as $tipo)
            <option value="{{ ($tipo) }}" @if(mb_strtolower($tipo)==mb_strtolower($profissional->tipo_profissional ?? '')) selected @endif>{{ $tipo }}</option>
            @endforeach
            @if(isset($profissional) && !in_array(mb_strtolower($profissional->tipo_profissional ?? ''), ['médico', 'enfermeiro', 'psicólogo', 'fisioterapeuta', 'nutricionista']))
            <option value="{{ $profissional->tipo_profissional }}" selected>{{ Str::title($profissional->tipo_profissional) }}</option>
            @endif
        </select>
        @error('tipo_profissional')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <!-- @if(empty($profissional->tipo_profissional))
        <small class="form-text alert alert-warning d-inline-block small ">Ao selecionar sua profissão não será possível alterar futuramente.</small>
        @endif -->
    </div>
    <div class="form-group col-md-4">
        <label for="email" class="required-label">E-mail<span class="required-asterisk">*</span></label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email ?? old('email') }}" required @if(empty($profissional)) data-toggle="tooltip" data-placement="top" title="Preencher os campos marcados com * resultará na criação de uma nova conta para o paciente." @endif>
        @error('email')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-2">
        <label for="senha" class="required-label">Senha<span class="required-asterisk">*</span></label>
        <input type="password" class="form-control" id="senha" name="senha" value="{{ $user->senha ?? old('senha') }}">
        @error('senha')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-2">
        <label for="cep">CEP</label>
        <input type="text" class="form-control" id="cep" name="cep" value="{{ $profissional->cep ?? old('cep') }}">
        @error('cep')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group col-md-1">
        <label for="uf">UF</label>
        <input type="text" class="form-control" id="uf" name="uf" value="{{ $profissional->uf ?? old('uf') }}">
        @error('uf')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-4">
        <label for="cidade">Cidade</label>
        <input type="text" class="form-control" id="cidade" name="cidade" value="{{ $profissional->cidade ?? old('cidade') }}" required>
        @error('cidade')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>


    <div class="form-group col-md-5">
        <label for="endereco">Endereço</label>
        <input type="text" class="form-control" id="endereco" name="endereco" value="{{ $profissional->endereco ?? old('endereco') }}" required>
        @error('endereco')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="bairro">Bairro</label>
        <input type="text" class="form-control" id="bairro" name="bairro" value="{{ $profissional->bairro ?? old('bairro') }}" required>
        @error('bairro')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group col-md-2">
        <label for="numero">Número</label>
        <input type="text" class="form-control" id="numero" name="numero" value="{{ $profissional->numero ?? old('numero') }}" required>
        @error('numero')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group col-md-6">
        <label for="complemento">Complemento</label>
        <input type="text" class="form-control" id="complemento" name="complemento" value="{{ $profissional->complemento ?? old('complemento') }}">
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#tipo_profissional').select2({
            theme: "bootstrap-5",
            tags: true, // Permite a criação de novos itens
            maximumSelectionLength: 3, // Define um limite de 3 tags criadas    
            dropdownParent: $('body') // Define o elemento pai do dropdown
        });
    });
    $(document).ready(function() {

        // Máscara para o campo CPF
        $('#cpf').inputmask('999.999.999-99');

        $('#rg').inputmask('99.999.999-99');

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
                $('#endereco').val(data.logradouro);
                $('#bairro').val(data.bairro);
                $('#complemento').val(data.complemento);
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