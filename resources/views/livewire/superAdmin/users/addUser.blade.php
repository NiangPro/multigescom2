<div class="container">
    <form wire:submit.prevent="store">
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
              @if (Auth()->user()->role !=="Super Admin")            
                <div class="form-group">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">Entreprise</div>
                      </div>
                      @if (Auth()->user()->role === 'Super Admin')
                      
                        <select class="form-control @error('form.entreprise_id') is-invalid @enderror"  wire:model="form.entreprise_id">
                          <option></option>
                          @foreach ($entreprises as $en)
                            @if ($en->sigle !== "SAM")
                              <option value="{{ $en->id }}">{{ $en->nom }}</option>
                            @endif
                          @endforeach
                        </select>
                        @error('form.entreprise_id')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      @else
                      <input type="text" readonly class="form-control" value="{{ Auth()->user()->entreprise->nom }}" placeholder="{{ Auth()->user()->entreprise->nom }}"> 
                      @endif
                    </div>
                </div>
              @endif
            </div>


        </div>
        @if ($etat === "add")
        <div class="form-group">
            <label class="form-label">Rôle</label>
            <div class="selectgroup selectgroup-pills" wire:change="changeEvent">
              <label class="selectgroup-item">
                <input type="radio" name="role" wire:model="form.role" value="Super Admin" class="selectgroup-input" checked="">
            <span class="selectgroup-button">Super Admin</span>
              </label>
              <label class="selectgroup-item">
                <input type="radio" name="role" wire:model="form.role" value="Admin" class="selectgroup-input">
                <span class="selectgroup-button">Admin</span>
              </label>
              {{-- @if (isset(Auth()->user()->role) && Auth()->user()->role !== "Super Admin")

              <label class="selectgroup-item">
                <input type="radio" name="role" wire:model="form.role" value="Comptable" class="selectgroup-input">
                <span class="selectgroup-button">Comptable</span>
              </label>
              <label class="selectgroup-item">
                <input type="radio" name="role" wire:model="form.role" value="Commercial" class="selectgroup-input" checked="">
                <span class="selectgroup-button">Commercial</span>
              </label>

              @endif --}}
              @error('form.role')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        @endif
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
         @if ($etat === "add")

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
        <button type="submit" class="btn btn-icon icon-left btn-success"><i class="far fa-edit"></i>@if ($etat === "add") Ajouter @else Modifier @endif</b>
        </form>
  </div>
