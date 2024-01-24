<div class="container">
    @if ($etat==='add')
      <form wire:submit.prevent="store">
        <div class="row d-flex">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">Prénom<span class="text-danger">*</span></div>
                          </div>
                          <input type="text" class="form-control @error('form.prenom') is-invalid @enderror" wire:model="form.prenom" placeholder="Le nom de l'utilisateur">
                          @error('form.prenom')
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
                            <div class="input-group-text">Nom<span class="text-danger">*</span></div>
                          </div>
                          <input type="text" class="form-control @error('form.nom') is-invalid @enderror" wire:model="form.nom" placeholder="Le nom de l'utilisateur">
                          @error('form.nom')
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
                                  <div class="input-group-text">N° Telephone<span class="text-danger">*</span></div>
                                </div>
                                <input type="tel" class="form-control @error('form.tel') is-invalid @enderror" wire:model="form.tel" placeholder="N° de Téléphone">
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
                                  <div class="input-group-text">Entreprise</div>
                                </div>
                                <input type="text" readonly class="form-control" value="{{Auth()->user()->entreprise->nom}}">
                              </div>
                          </div>
                      </div>
                  </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <div class="input-group-text">Email<span class="text-danger">*</span></div>
                              </div>
                              <input type="email" class="form-control @error('form.email') is-invalid @enderror" wire:model="form.email" placeholder="L'email de l'utilisateur">
                              @error('form.email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="selectgroup selectgroup-pills">
                                Sexe
                              <label class="selectgroup-item">
                                <input type="radio" name="icon-input" value="Homme" class="selectgroup-input @error('form.sexe') is-invalid @enderror" wire:model="form.sexe" checked="">
                                <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-male"></i></span>
                              </label>
                              <label class="selectgroup-item">
                                <input type="radio" name="icon-input" value="Femme" class="selectgroup-input @error('form.sexe') is-invalid @enderror" wire:model="form.sexe">
                                <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-female"></i></span>
                              </label>
                              @error('form.sexe')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                @if ($etat === "add" || $etat === "exist")
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <div class="input-group-text">Mot de passe<span class="text-danger">*</span></div>
                              </div>
                              <input type="password" class="form-control @error('form.password') is-invalid @enderror" wire:model="form.password" placeholder="Le mot de passe de l'utilisateur">
                              @error('form.password')
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
                                <div class="input-group-text">Confirmation<span class="text-danger">*</span></div>
                              </div>
                              <input type="password" class="form-control @error('form.password_confirmation') is-invalid @enderror" wire:model="form.password_confirmation" placeholder="Le mot de passe de confirmation">
                              @error('form.password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                @endif
              </div>
            </div>
            @if ($etat === "add" || $etat === "exist") 
            <button type="submit" class="btn btn-icon icon-left btn-success"><i class="fa fa-plus"></i>
              Ajouter 
            </button>
            <button type="reset" class="btn btn-warning">Annuler</button>
            @endif
            @if ($etat === "info" && Auth()->user()->entreprise->nom !== "Demo") 
              <button type="submit" class="btn btn-icon icon-left btn-success"><i class="far fa-edit"></i>
                modifier 
              </button>
            @endif
            
        </div>
      </form>
    @endif    
    @if($etat==='exist')
      <form wire:submit.prevent="exist">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">Employé</div>
                </div>
                <select class="form-control" wire:click="changeEvent($event.target.value)">
                  <option value="">Selectionner un employé</option>
                  @foreach ($employes as $em)
                      <option value="{{ $em->id }}">{{ $em->prenom }} {{ $em->nom }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-icon icon-left btn-success"><i class="far fa-edit"></i>Ajouter</b>
            <button type="reset" class="btn btn-warning ml-2"> Annuler</button>
        </div>
        </div>
      </form>
    @endif    
</div>
