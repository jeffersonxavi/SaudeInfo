<div class="form-group">
    <label for="especialidades">Especialidades</label>
    <div class="row">
        @if(isset($especialidades))
        @foreach($especialidades as $especialidade)
        <div class="col-md-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="especialidades[]" value="{{ $especialidade->id }}" @if(isset($profissional) && $profissional->especialidades->contains($especialidade)) checked @endif>
                <label class="form-check-label" for="especialidade{{ $especialidade->id }}">
                    {{ $especialidade->nome }}
                </label>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>