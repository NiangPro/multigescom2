<div class="container @if ($etat === "add")
    col-md-5
@endif ">
    <form wire:submit.prevent="store">
        <div class="form-group">
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Nom<span class="text-danger">*</span></div>
              </div>
              <input type="text" class="form-control @error('form.nom') is-invalid @enderror" wire:model="form.nom" placeholder="Le nom de l'entreprise">
              @error('form.nom')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
          </div>
          <div class="form-group">
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Sigle<span class="text-danger">*</span></div>
              </div>
              <input type="text" class="form-control @error('form.sigle') is-invalid @enderror" wire:model="form.sigle" placeholder="Le sigle de l'entreprise">
              @error('form.sigle')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
          </div>
          <div class="form-group">
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">N° Telephone<span class="text-danger">*</span></div>
              </div>
              <input type="tel" class="form-control @error('form.tel') is-invalid @enderror" wire:model="form.tel" placeholder="Le numéro téléphone de l'entreprise">
              @error('form.tel')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
          </div>
          <div class="form-group">
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Adresse<span class="text-danger">*</span></div>
              </div>
              <input type="text" class="form-control @error('form.adresse') is-invalid @enderror" wire:model="form.adresse" placeholder="L'adresse de l'entreprise">
              @error('form.adresse')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
          </div>
          <div class="form-group">
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Email<span class="text-danger">*</span></div>
              </div>
              <input type="email" class="form-control @error('form.email') is-invalid @enderror" wire:model="form.email" placeholder="L'email de l'entreprise">
              @error('form.email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
          </div>
          <div class="form-group">
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Fermeture<span class="text-danger">*</span></div>
              </div>
              <input type="date" wire:model="form.fermeture" class="form-control @error('form.fermeture') is-invalid @enderror" placeholder="La date de fermeture">
              @error('form.fermeture')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
          </div>
          <button type="submit" class="btn btn-icon icon-left btn-success"><i class="far fa-edit"></i>@if ($etat === "add")
              Ajouter
          @else
              Modifier
          @endif </button>
      </form>
  </div>
