<div class="card mt-2 card-primary">
    <div class="card-header">
        <h4>
            Formulaire 
            @if ($status ==="editTache")
                de modification tâche
             @else
                d'ajout tache
            @endif</h4>
        <div class="card-header-action">
          <div class="btn-group">
              <button wire:click.prevent="changeEtat('listTaches')" class="btn btn-primary"><i class="fa fa-list"></i> Liste</button>
          </div>
        </div>
    </div>
    <div class="card-body container col-10 mt-0">
        <form wire:submit.prevent="store">
            <div class="row">
                <div class="col-md-6">
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
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Assignation<span class="text-danger">*</span></div>
                            </div>
                            <select class="form-control @error('form.assignation') is-invalid @enderror" wire:model="form.assignation" id="exampleFormControlSelect1">
                                <option value="">Selectionner un employé</option>
                                @foreach ($employes as $item)
                                    <option value="{{$item->id}}">{{$item->prenom}} {{$item->nom}}</option>
                                @endforeach
                            </select>
                            @error('form.assignation')
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
                            <div class="input-group-text">Date Début<span class="text-danger">*</span></div>
                          </div>
                          <input type="date" class="form-control @error('form.date_debut') is-invalid
                            @enderror" wire:model="form.date_debut">
                            @error('form.date_debut')
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
                            <div class="input-group-text">Date Fin<span class="text-danger">*</span></div>
                          </div>
                          <input type="date" class="form-control @error('form.date_fin') is-invalid
                            @enderror" wire:model="form.date_fin">
                            @error('form.date_fin')
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
                            <textarea placeholder="Description" class="form-control @error('form.description') is-invalid
                            @enderror" wire:model="form.description"></textarea>
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
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Priorité<span class="text-danger">*</span></div>
                            </div>
                            <select class="form-control @error('form.priorite') is-invalid @enderror" wire:model="form.priorite" id="exampleFormControlSelect1">
                                <option value="">Selectionner une priorité</option>
                                @foreach ($staticData as $item)
                                    <option value="{{$item->valeur}}">{{$item->valeur}}</option>
                                @endforeach
                            </select>
                            @error('form.priorite')
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
                                <div class="input-group-text">Statut<span class="text-danger">*</span></div>
                            </div>
                            <select class="form-control @error('form.statut') is-invalid @enderror" wire:model="form.statut" id="exampleFormControlSelect1">
                                <option value="">Selectionner un statut</option>
                                <option value="En attente">En attente</option>
                                <option value="En cours">En cours</option>
                                <option value="Terminé">Terminé</option>
                            </select>
                            @error('form.priorite')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                @if ($status ==="addTache") 
                    <button type="submit" class="btn btn-icon icon-left btn-success"><i class="fa fa-plus"></i>
                    Ajouter 
                    </button>
                    <button type="reset" class="btn btn-warning">Annuler</button>
                @endif
                @if ($status ==="editTache" && Auth()->user()->entreprise->nom !== "Demo") 
                    <button type="submit" class="btn btn-icon icon-left btn-success"><i class="far fa-edit"></i>
                        modifier 
                    </button>
                @endif
                
            </div>
        </form>
    </div>
</div>
