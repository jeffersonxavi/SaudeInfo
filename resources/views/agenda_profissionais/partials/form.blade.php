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
                    @foreach($profissionais as $profissional)
                    <option value="{{ $profissional->id }}" {{ isset($agendaProfissional) && $agendaProfissional->profissional_id == $profissional->id ? 'selected' : '' }}>
                        {{ $profissional->nome }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="inicio_atendimento">Início do Atendimento:</label>
                <input type="time" class="form-control small-time-input" id="inicio_atendimento" name="inicio_atendimento" value="{{ $agendaProfissional->inicio_atendimento ?? old('inicio_atendimento') }}" required>
            </div>
            <div class="form-group col-md-2">
                <label for="intervalo">Intervalo:</label>
                <input type="time" class="form-control small-time-input" id="intervalo" name="intervalo" value="{{ $agendaProfissional->intervalo ?? old('intervalo') }}" required>
            </div>
            <div class="form-group col-md-2">
                <label for="fim_atendimento">Fim do Atendimento:</label>
                <input type="time" class="form-control small-time-input" id="fim_atendimento" name="fim_atendimento" value="{{ $agendaProfissional->fim_atendimento ?? old('fim_atendimento') }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="max_atendimentos">Máximo de Atendimentos:</label>
                <input type="number" class="form-control" id="max_atendimentos" name="max_atendimentos" value="{{ $agendaProfissional->max_atendimentos ?? old('max_atendimentos') }}" required>
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
                <input type="checkbox" class="form-check-input" id="{{ $dia }}" name="{{ $dia }}" value="1" {{ isset($agendaProfissional) && $agendaProfissional->$dia ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $dia }}">{{ ($dia == 'sabado' || $dia == 'domingo') ? ucfirst($dia) : ucfirst($dia) . '-feira' }}</label>
            </div>
        </div>
    </div>
</div>
@endforeach

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
</script>
@endpush