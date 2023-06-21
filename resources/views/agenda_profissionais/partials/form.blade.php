<style>
    /* Reduzir o tamanho dos inputs do tipo "time" */
    .small-time-input {
        width: 100px;
        height: 30px;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="profissional_id">Nome do Profissional:</label>
                <select class="tags form-control" id="profissional_id" name="profissional_id" required>
                    <option value="">Insira seu nome</option>
                    <option value="{{ isset($agendaProfissional) ? $agendaProfissional->profissional->id : '' }}" {{ isset($agendaProfissional) && $agendaProfissional->profissional_id == $agendaProfissional->profissional->id ? 'selected' : '' }}>
                        {{ isset($agendaProfissional) ? $agendaProfissional->profissional->nome : 'Nome Padrão' }}
                    </option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="inicio_atendimento">Início Atendimento:</label>
                <input type="time" class="form-control small-time-input @error('inicio_atendimento') is-invalid @enderror" id="inicio_atendimento" name="inicio_atendimento" value="{{ $agendaProfissional->inicio_atendimento ?? old('inicio_atendimento') }}">
                @error('inicio_atendimento')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-2">
                <label for="intervalo">Intervalo:</label>
                <input type="time" class="form-control small-time-input @error('intervalo') is-invalid @enderror" id="intervalo" name="intervalo" value="{{ $agendaProfissional->intervalo ?? old('intervalo') }}">
                @error('intervalo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-2">
                <label for="fim_atendimento">Fim do Atendimento:</label>
                <input type="time" class="form-control small-time-input @error('fim_atendimento') is-invalid @enderror" id="fim_atendimento" name="fim_atendimento" value="{{ $agendaProfissional->fim_atendimento ?? old('fim_atendimento') }}">
                @error('fim_atendimento')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="max_atendimentos">Máximo de Atendimentos:</label>
                <input type="number" class="form-control @error('max_atendimentos') is-invalid @enderror" id="max_atendimentos" name="max_atendimentos" value="{{ $agendaProfissional->max_atendimentos ?? old('max_atendimentos') }}" required>
                @error('max_atendimentos')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-8">
                <label for="observacoes">Observações:</label>
                <textarea class="form-control" id="observacoes" name="observacoes">{{ $agendaProfissional->observacoes ?? old('observacoes') }}</textarea>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <label for="dia">Selecione os dias de Trabalho:</label>
        <div class="form-row">
            @php
            $diasSemana = ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo'];
            @endphp
            @foreach($diasSemana as $dia)
            <div class="form-group col-md-2">
                <div class="card">
                    <div class="card-body">
                        <div class="form-check">
                            <input type="hidden" name="{{ $dia }}" value="0">
                            <input type="checkbox" class="form-check-input dia-checkbox" id="{{ $dia }}" name="{{ $dia }}" value="1" {{ isset($agendaProfissional) && $agendaProfissional->$dia ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $dia }}">{{ ($dia == 'sabado' || $dia == 'domingo') ? ucfirst($dia) : ucfirst($dia) . '-feira' }}</label>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="form-group col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-check">
                            <input type="hidden" name="todosDias" value="0">
                            <input type="checkbox" class="form-check-input" id="todosDiasCheckbox" name="todosDias" value="1" onclick="marcarTodos()">
                            <label class="form-check-label" for="todosDiasCheckbox">Marcar todos os dias</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
    $(document).ready(function() {
        $('.profissional_id').select2({
            placeholder: "Insira seu nome",
            allowClear: true,
            language: "pt-BR" // Defina o idioma como "pt-BR" para português do Brasil

        });
        const $select = $('#profissional_id');
        $select.select2({
            theme: "bootstrap-5",
            minimumInputLength: 1, // Defina o número mínimo de caracteres para 3
            language: {
                inputTooShort: function() {
                    return "Digite pelo menos 1 caracteres";
                }
            },
            ajax: {
                url: "{{ route('profissionais.buscar') }}",
                type: "post",
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        nome: params.term,
                        "_token": "{{ csrf_token() }}",
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.nome
                            }
                        })
                    };
                },
            }
        })
    });
    function marcarTodos() {
        var checkboxes = document.querySelectorAll('input[name^="segunda"], input[name^="terca"], input[name^="quarta"], input[name^="quinta"], input[name^="sexta"], input[name^="sabado"], input[name^="domingo"]');
        var todosDiasCheckbox = document.getElementById('todosDiasCheckbox');

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = todosDiasCheckbox.checked;
        }
    }
</script>
@endpush