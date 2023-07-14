@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header bg-primary-custom">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Profissionais</h4>
          <a href="{{ route('profissionais.create') }}" class="btn btn-primary btn-sm text-white custom-btn-primary">
            <i class="fas fa-plus"></i> Adicionar Profissional
          </a>
        </div>
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show my-custom-alert" role="alert">
          <strong>Sucesso!</strong> {{ session('success') }}
          <button type="button" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
        <script>
          setTimeout(function() {
            $('.alert-success').fadeOut('slow');
          }, 4000);
        </script>
        @endif
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="myTable" class="table table-striped">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Tipo de Profissional</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>Ações</th>
              </tr>
            </thead>
          </table>
          <div class="d-flex justify-content-center mt-4">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
  //adicionando DataTables
  let table = new DataTable('#myTable', {
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json",
      "processing": ""

    },
    autoWidth: false, // Desabilita a largura automática das colunas
    responsive: true, // Habilita a funcionalidade responsiva
    // scrollX: true, // Adicione esta opção para permitir rolagem horizontal
    processing: true,
    serverSide: true,
    searching: true,
    ajax: {
      url: "{{route('profissionais.ajax')}}",
      method: 'GET',
    },
    columns: [{
        data: 'nome',
        name: 'nome'
      },
      {
        data: 'tipo_profissional',
        name: 'tipo_profissional'
      },
      {
        data: 'cpf',
        name: 'cpf'
      },
      {
        data: 'telefone',
        name: 'telefone'
      },
      {
        data: 'id',
        name: 'acoes',
        orderable: false,
        searchable: false,
        render: function(data, type, row, meta) {
          var editUrl = "{{ route('profissionais.edit', ':id') }}".replace(':id', row.id);
          return `
            <div class="btn-group">
              <a href="${editUrl}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
              <button class="btn btn-sm btn-secondary delete-btn" data-id="${row.id}"><i class="far fa-trash-alt"></i></
            </div>
          `;
        }
      }
    ]
  });
  $(document).on('click', '.delete-btn', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    Swal.fire({

      title: 'Tem certeza?',
      text: 'Essa ação é irreversível.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Sim, excluir',
      cancelButtonText: 'Cancelar',
      allowOutsideClick: false,
      preConfirm: function() {
        return new Promise(function(resolve) {
          Swal.showLoading();
          $('.swal2-cancel').hide();
          const url = "{{route('profissionais.destroy', ':id')}}".replace(':id', id);
          $.ajax({
            url: url,
            type: 'POST',
            data: {
              _method: 'DELETE',
              _token: '{{ csrf_token() }}'
            },
            success: function() {
              table.ajax.reload();
              Swal.fire({
                title: 'Excluído!',
                text: 'O registro foi excluído com sucesso.',
                icon: 'success',
              });
              resolve();
            },
            error: function() {
              Swal.fire({
                title: 'Erro!',
                text: 'Ocorreu um erro ao excluir o registro.',
                icon: 'error'
              });
              resolve();
            }
          });
        });
      }
    });
  });
</script>
@endpush