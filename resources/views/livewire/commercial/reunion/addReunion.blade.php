<div class="card mt-2 card-primary">
    <div class="card-header">
        <h4>
            Formulaire 
            @if ($status ==="editReunion")
                de modification reunion
             @else
                d'ajout reunion
            @endif</h4>
        <div class="card-header-action">
          <div class="btn-group">
              <button wire:click.prevent="changeEtat('listReunions')" class="btn btn-primary"><i class="fa fa-list"></i> Liste</button>
          </div>
        </div>
    </div>
    <div class="card-body container col-8 mt-0">
        <form wire:submit.prevent="store">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">Titre<span class="text-danger">*</span></div>
                          </div>
                          <input type="text" class="form-control @error('form.titre') is-invalid
                            @enderror" placeholder="Titre" wire:model="form.titre">
                            @error('form.titre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">Description<span class="text-danger">*</span></div>
                          </div>
                          <textarea class="form-control @error('form.description') is-invalid
                            @enderror" placeholder="Description" wire:model="form.description"></textarea>
                            @error('form.description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">Date<span class="text-danger">*</span></div>
                          </div>
                          <input type="datetime-local" class="form-control @error('form.date') is-invalid
                            @enderror" wire:model="form.date">
                            @error('form.date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            @if ($status ==="addReunion") 
                <button type="submit" class="btn btn-icon icon-left btn-success"><i class="fa fa-plus"></i>
                    Ajouter 
                </button>
                <button type="reset" class="btn btn-warning">Annuler</button>
            @endif
            @if ($status ==="editReunion" && Auth()->user()->entreprise->nom !== "Demo") 
                <button type="submit" class="btn btn-icon icon-left btn-success"><i class="far fa-edit"></i>
                    modifier 
                </button>
            @endif
        </form>
    </div>
</div>
