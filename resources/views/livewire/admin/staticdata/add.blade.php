<div class="card card-primary col-md-5 container">
    <div class="card-header">
      <h4>{{ $data['subtitle'] }}</h4>
      <div class="card-header-action">
        <div class="btn-group">
            <button wire:click.prevent="retour" class="btn btn-info">Retour</button>

        </div>
      </div>
    </div>
    <div class="card-body">
        <form method="POST" wire:submit.prevent="save">
            <div class="form-group controls">
                <label for="">Type</label>
                <select wire:model="form.type" class="form-control @error('form.type') is-invalid @enderror">
                    <option value="">Selectionner un type</option>
                    @foreach ($types as $t)
                        <option value="{{$t->type}}">{{$t->type}}</option>
                    @endforeach
                </select>
                @error('form.type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <div class="controls">
                    <label for="">Valeur</label>
                    <input type="text"  wire:model="form.valeur"  class="form-control @error('form.valeur') is-invalid @enderror">
                    @error('form.valeur')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            @if ($form['id'])
            <button class="btn btn-outline-warning">Modifier</button>
            @else
            <button class="btn btn-outline-success">Ajouter</button>
            @endif
        </form>

    </div>
</div>
