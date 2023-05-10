<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0"><i class="fas fa-stethoscope"></i> Especialidades</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary bg-primary" data-toggle="modal" data-target="#addEspecialidadeModal">
                    <i class="fas fa-plus"></i> Adicionar Especialidade
                </button>
            </div>
        </div>
        <div id="especialidades-checkboxes" class="row">
            @foreach($especialidades as $especialidade)
            @if(isset($profissional) && $profissional->especialidades->contains($especialidade)) <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="especialidades[]" value="{{ $especialidade->id }}" @if(isset($profissional) && $profissional->especialidades->contains($especialidade)) checked disabled @endif>
                            <label class="form-check-label" for="especialidade{{ $especialidade->id }}">
                                {{ $especialidade->nome }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>
<div class="modal fade" id="addEspecialidadeModal" tabindex="-1" role="dialog" aria-labelledby="addEspecialidadeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addEspecialidadeModalLabel"><i class="fas fa-plus"></i> Adicionar Especialidade</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addEspecialidadeForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="especialidades"><strong>Selecione ou remova as especialidades desejadas:</strong></label>
                        <select id="especialidades" class="form-control select2" multiple="multiple" name="especialidades[]">
                            @foreach($especialidades as $especialidade)
                            <option value="{{ $especialidade->id }}" @if(isset($profissional) && $profissional->especialidades->contains($especialidade)) selected @endif>{{ $especialidade->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary bg-primary" data-dismiss="modal"><i class="fas fa-times"></i> Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        const $select = $('#especialidades');
        $select.select2({
            theme: "bootstrap-5",
            tags: true, // Permite a criação de novos itens
            dropdownParent: $('body'),
        });

        function adicionarNovaEspecialidade(novaTag) {
            $.ajax({
                url: '{{ route("especialidades.store") }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    tag: novaTag
                },
                beforeSend: function() {
                    // Exibe a animação de carregamento
                    $select.attr('disabled', true).addClass('loading');
                },
                success: function(response) {
                    // Cria a nova opção e a adiciona ao select
                    const novaOpcao = new Option(novaTag, response.id, true, true);
                    $select.append(novaOpcao).trigger('change');

                    // Adiciona um novo checkbox na lista de especialidades se não existir
                    const checkboxExistente = $('input[name="especialidades[]"][value="' + response.id + '"]');
                    if (checkboxExistente.length === 0) {
                        const novoCheckbox = '<div class="col-md-4 mb-3">' +
                            '<div class="card">' +
                            '<div class="card-body">' +
                            '<div class="form-check">' +
                            '<input class="form-check-input" type="checkbox" name="especialidades[]" value="' + response.id + '" checked onclick="return false;">' +
                            '<label class="form-check-label" for="especialidade' + response.id + '">' +
                            novaTag +
                            '</label>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                        $('#especialidades-checkboxes').append(novoCheckbox);
                    } else {
                        checkboxExistente.prop('checked', true);
                    }
                    // Fecha o modal
                    $('#addEspecialidadeModal').hide('modal');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                },
                error: function() {
                    console.log('Ocorreu um erro ao adicionar a nova especialidade.');
                },
                complete: function() {
                    // Remove a animação de carregamento
                    $select.attr('disabled', false).removeClass('loading');
                }
            });
        }

        $select.on('select2:selecting', function(e) {
            const novaTag = e.params.args.data.text;
            adicionarNovaEspecialidade(novaTag);
            e.preventDefault();
        });

        $select.on('select2:unselect', function(e) {
            const removedTag = e.params.data.text;
            const checkbox = $('#especialidades-checkboxes input[value="' + e.params.data.id + '"]');
            checkbox.prop('checked', false);
        });
    });
</script>
@endpush