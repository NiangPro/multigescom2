    <div class="card card-primary mt-3">
        <div class="card-header">
            <h4>
                @if ($etat === "add")
                    Formulaire d'ajout employé
                @elseif($etat === "info")
                    Informations personnelles
                @endif
            </h4>
            <div class="card-header-action">
              <div class="btn-group">
                @if ($etat === "info")
                    <a wire:click.prevent="changeStatut('list')" class="float-right d-flex" type="button">
                        {{-- <i class="fa fa-folder-open fa-2x text-primary"></i>  --}}
                        <img src="{{asset('storage/images/doc.png')}}" width="50" height="50" alt="">
                        <strong class="pt-2 text-primary">  Voir contrat</strong>
                    </a>
                @endif
              </div>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Prenom <span class="text-danger">*</span></label>
                            <input placeholder="Prénom" type="text" class="form-control @error('form.prenom') is-invalid @enderror" wire:model="form.prenom">
                            @error('form.prenom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Nom <span class="text-danger">*</span></label>
                            <input placeholder="Nom" type="text" class="form-control @error('form.nom') is-invalid @enderror" wire:model="form.nom">
                            @error('form.nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Email <span class="text-danger">*</span></label>
                            <input placeholder="Email" type="email" class="form-control @error('form.email') is-invalid @enderror" wire:model="form.email">
                            @error('form.email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">N° Telephone <span class="text-danger">*</span></label>
                            <input placeholder="Tel" type="tel" class="form-control @error('form.tel') is-invalid @enderror" wire:model="form.tel">
                            @error('form.tel')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Sexe <span class="text-danger">*</span></label>
                            <select class="form-control @error('form.sexe') is-invalid @enderror" wire:model="form.sexe" id="exampleFormControlSelect1">
                                <option value="Homme">Selectionner un sexe</option>
                                <option value="Homme">Homme</option>
                                <option value="Femme">Femme</option>
                            </select>
                            @error('form.sexe')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Adresse <span class="text-danger">*</span></label>
                            <input placeholder="Adresse" type="text" class="form-control @error('form.adresse') is-invalid @enderror" wire:model="form.adresse">
                            @error('form.adresse') <span class="error text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Fonction <span class="text-danger">*</span></label>
                            <select class="form-control @error('form.fonction') is-invalid @enderror" wire:model="form.fonction">
                                <option value="">Selectionner une fonction</option>
                                @foreach ($staticData as $f)
                                    <option value="{{$f->valeur}}">{{$f->valeur}}</option>
                                @endforeach
                            </select>
                            @error('form.fonction') <span class="error text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Pays <span class="text-danger">*</span></label>
                            <select class="form-control @error('form.pays') is-invalid @enderror" wire:model="form.pays" id="exampleFormControlSelect1">
                                @foreach ($country as $c)
                                    <option value="{{$c->id}}" @if ($c->nom_fr === "Sénégal")
                                        selected
                                    @endif >{{$c->nom_fr}}</option>
                                @endforeach
                            </select>
                            @error('form.pays') <span class="error text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>
                </div>
                
                    <div class="row">
                        <div class="col-md-12">
                            <div class="align-items-end">
                                @if ($etat === "add")
                                    <button type="reset" class="btn btn-warning">Annuler</button>
                                
                                    <button type="submit" class="btn btn-success">
                                        Ajouter
                                    </button>
                                @endif
                                @if ($etat === "info" && Auth()->user()->entreprise->nom !== "Demo")
                                    <button type="submit" class="btn btn-success">
                                        Modifier
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

            </form>
        </div>
    </div>
