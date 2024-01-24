<div>
    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-3">
          <div class="card profile-widget card-primary">
            <div class="profile-widget-header">
                @if ($profil)
                <img alt="image" height="80" width="80" src="{{$profil->temporaryUrl()}}" class="rounded-circle profile-widget-picture">
                @else
                <img alt="image" height="80" width="80" src="storage/images/{{ $user->profil}}" class="rounded-circle profile-widget-picture">
              @endif
              <div class="profile-widget-items">
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">
                      <button  class="btn btn-icon btn-primary btn-sm" wire:click.prevent="changeEtat('list')"><i class="fa fa-arrow-left" aria-hidden="true"></i>Retour</button>
                  </div>
                  {{-- <div class="profile-widget-item-value">6,8K</div> --}}
                </div>
              </div>
            </div>
            <div class="profile-widget-description">
                <div class="profile-widget-name">{{ $user->prenom}} {{ $user->nom}}
                    <div class="text-muted d-inline font-weight-normal">
                      <div class="slash"></div> {{ $user->role}}
                    </div>
                </div>
            </div>
            @if (Auth()->user()->entreprise->nom !== "Demo")
              <div class="card-footer text-center">
                  <div class="input-group mb-3">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" wire:model="profil" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputGroupFile01">Choisir</label>
                        <div wire:loading wire:target="profil">Chargement...</div>
                      </div>
                  </div>
                  <button class="btn btn-icon icon-left btn-success" wire:click.prevent="editProfil">Changer</button>
              </div>
            @endif
          </div>
        </div>
        <div class="col-12 col-md-12 col-lg-9">
          <div class="card card-primary">
            <div class="card-header">
                <h4>Information du profil</h4>
              </div>
              <div class="card-body">
                  @include('livewire.admin.commerciaux.addCommercial')
            </div>
          </div>
        </div>
    </div>
    
    @if (Auth()->user()->entreprise->nom !== "Demo")
        <div class="card card-primary">
          <form wire:submit.prevent="editPassword"  class="needs-validation" novalidate="">
            <div class="card-header">
              <h4>Reinitialisation du mot de passe</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
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
                    <div class="col-md-5">
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
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-icon icon-left btn-success"><i class="far fa-edit"></i>Modifier</b>
    
                    </div>
                </div>
    
            </div>
          </form>
        </div>
    @endif
    </div>
    