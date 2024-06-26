<div class="card mt-2 card-primary">
    <div class="card-header">
        <h4>
            Formulaire 
            @if ($status ==="editClient")
                de modification client
             @else
                d'ajout client
            @endif</h4>
        <div class="card-header-action">
          <div class="btn-group">
              <button wire:click.prevent="changeEtat('listClients')" class="btn btn-primary"><i class="fa fa-list"></i> Liste</button>
          </div>
        </div>
    </div>
    <div class="card-body container col-8 mt-0">
        <form wire:submit.prevent="store">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">Nom<span class="text-danger">*</span></div>
                          </div>
                          <input type="text" class="form-control @error('form.nom') is-invalid
                            @enderror" placeholder="Nom" wire:model="form.nom">
                            @error('form.nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">Adresse<span class="text-danger">*</span></div>
                          </div>
                          <input type="text" class="form-control @error('form.adresse') is-invalid
                            @enderror" placeholder="Adresse" wire:model="form.adresse">
                            @error('form.adresse')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">Téléphone<span class="text-danger">*</span></div>
                          </div>
                          <input type="tel" class="form-control @error('form.tel') is-invalid
                            @enderror" placeholder="Téléphone" wire:model="form.tel">
                            @error('form.tel')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">Email<span class="text-danger">*</span></div>
                          </div>
                          <input type="email" class="form-control @error('form.email') is-invalid
                            @enderror" placeholder="Email" wire:model="form.email">
                            @error('form.email')
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
                                <div class="input-group-text">Pays<span class="text-danger">*</span></div>
                            </div>
                            <select class="form-control @error('form.country_id') is-invalid @enderror" wire:model="form.country_id" id="exampleFormControlSelect1">
                                @foreach ($country as $c)
                                    <option value="{{$c->id}}" @if ($c->nom_fr === "Sénégal")
                                        selected
                                    @endif>{{$c->nom_fr}}</option>
                                @endforeach
                            </select>
                            @error('form.country_id') <span class="error text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>   
                </div>
            </div>
            
            <div class="mb-4">
                @if ($status ==="addClient")
                    <button type="reset" class="btn btn-warning">Annuler</button>&nbsp;&nbsp;
                    <button type="submit" class="btn btn-success">
                        Ajouter
                    </button>
                @endif
                @if (Auth()->user()->entreprise->nom !== "Demo")
                    @if ($status ==="editClient")
                        <button type="submit" class="btn btn-success">
                            Modifier
                        </button>
                    @endif
                @endif
            </div>
        </form>
    </div>
</div>
