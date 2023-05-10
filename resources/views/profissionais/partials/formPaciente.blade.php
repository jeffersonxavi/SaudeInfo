<table id="pacientes-table" class="table table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Paciente</th>
            <th>Status</th>
        </tr>
    </thead>
</table>

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    //adicionando DataTables
    let table = new DataTable('#pacientes-table', {
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
        },
        processing: true,
        serverSide: true,
        searching: true,
        paginate: true,
        ajax: "{!! route('profissionais.pacientes', $profissional->id) !!}",
        columns: [{
                data: 'id'
            },
            {
                data: 'nome'
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var select = `<select class="form-select select-status" data-id="${row.id}">
                    <option value="1" ${row.vinculado ? "selected" : ""}>ATIVO</option>
                    <option value="0" ${!row.vinculado ? "selected" : ""}>INATIVO</option>
                    </select>`;
                    return select;
                }
            }
        ],



    });


    $('body').on('change', '.form-select', function() {
        var ativo = $(this).val();
        var paciente_id = $(this).closest('tr').find('td:eq(0)').text();

        $.ajax({
            type: 'PUT',
            url: '{{ route("profissional.atualizarPaciente", $profissional->id) }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'paciente_id': paciente_id,
                'ativo': ativo
            },
            success: function(response) {
                // exibir uma mensagem de sucesso
            }
        });
    });
</script>
@endpush