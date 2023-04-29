<table id="pacientes-table" class="datatable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Paciente</th>
            <th>Status</th> <!-- Nova coluna para o select ativo/inativo -->
        </tr>
    </thead>
    <tbody>
        @if(isset($pacientes))
        @foreach($pacientes as $paciente)
        <tr>
            <td>{{ $paciente->id }}</td>
            <td>{{ $paciente->nome }}</td>
            <td>
            <select class="form-select" name="pacientes[{{ $paciente->id }}]">
    <option value="1" data-order="1" {{ $profissional->pacientes->contains($paciente) ? 'selected' : '' }}>Ativo</option>
    <option value="0" data-order="0" {{ !$profissional->pacientes->contains($paciente) ? 'selected' : '' }}>Inativo</option>
</select>

            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>