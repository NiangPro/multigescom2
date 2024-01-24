<div class="card mt-2 card-primary">
    <div class="card-header">
        <h4>
            Formulaire 
            @if ($status ==="editProspect")
                de modification prospect
             @else
                d'ajout prospect
            @endif</h4>
        <div class="card-header-action">
          <div class="btn-group">
              <button wire:click.prevent="changeEtat('listProspects')" class="btn btn-primary"><i class="fa fa-list"></i> Liste</button>
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
                            <div class="input-group-text">Source<span class="text-danger">*</span></div>
                          </div>
                          <select class="form-control @error('form.source') is-invalid @enderror" wire:model="form.source" id="exampleFormControlSelect1">
                            <option value="">Selectionner une source</option>
                                @foreach ($staticData as $item)
                                    <option value="{{$item->id}}">{{$item->valeur}}</option>
                                @endforeach
                            </select>
                            @error('form.source')
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
                                <div class="input-group-text">Assigné à<span class="text-danger">*</span></div>
                            </div>
                            <select class="form-control @error('form.assignation') is-invalid @enderror" wire:model="form.assignation" id="exampleFormControlSelect1">
                                <option value="">Selectionner un employé</option>
                                @foreach ($employes as $item)
                                    <option value="{{$item->id}}">{{$item->prenom}} {{$item->nom}}</option>
                                @endforeach
                            </select>
                            @error('form.assignation') <span class="error text-danger">{{$message}}</span> @enderror
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
                @if ($status ==="addProspect") 
                    <button type="submit" class="btn btn-icon icon-left btn-success"><i class="fa fa-plus"></i>
                        Ajouter 
                    </button>
                    <button type="reset" class="btn btn-warning">Annuler</button>
                @endif
                @if ($status ==="editProspect" && Auth()->user()->entreprise->nom !== "Demo") 
                    <button type="submit" class="btn btn-icon icon-left btn-success"><i class="far fa-edit"></i>
                        modifier 
                    </button>
                @endif
        </form>
    </div>
</div>
