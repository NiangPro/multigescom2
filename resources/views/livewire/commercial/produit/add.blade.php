<div class="card mt-2 card-primary">
    <div class="card-header">
        <h4>
            Formulaire @if ($status ==="editProduct")
                de modification @else
                d'ajout
            @endif  produit / service</h4>
        <div class="card-header-action">
          <div class="btn-group">
              <button wire:click.prevent="changeEtat('listProduct')" class="btn btn-primary"><i class="fa fa-list"></i> Liste</button>
          </div>
        </div>
    </div>

    <div class="card-body mt-0 row">
        @if ($status ==="editProduct")
            <div class="container col-md-4 mt-4">
                <div class="card rounded">
                    <div class="card-image">     
                        @if ($image_produit)
                            <img src="{{$image_produit->temporaryUrl()}}" alt="Responsive image" class="product_img">
                        @else
                            <img alt="Responsive image" src="storage/images/{{ $current_produit->image_produit}}" class="product_img">
                        @endif
                    </div>
                    @if (Auth()->user()->entreprise->nom !== "Demo")
                        <div class="card-footer text-center mt-n4">
                            <div class="input-group mb-3">
                                <div class="custom-file mt-4">
                                    <input type="file" class="custom-file-input" wire:model="image_produit" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">Choisir</label>
                                    <div wire:loading wire:target="image_produit">Chargement...</div>
                                </div>
                            </div>
                            <button class="btn btn-icon icon-left btn-success" wire:click.prevent="editImage">Changer</button>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        <div class="container col-md-6">
            <form wire:submit.prevent="store" class="mt-4">
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
                <div class="form-group">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">Description<span class="text-danger">*</span></div>
                      </div>
                      <input type="text" class="form-control @error('form.description') is-invalid
                      @enderror" wire:model="form.description" placeholder="Description">
                        @error('form.description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">Tarif<span class="text-danger">*</span></div>
                      </div>
                      <input type="number" min="1" class="form-control @error('form.tarif') is-invalid
                      @enderror" wire:model="form.tarif" placeholder="Tarif">
                        @error('form.tarif')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">Type</label>
                        <div class="selectgroup selectgroup-pills">
                            <label class="selectgroup-item">
                                <input type="radio" name="type" value="Produit" class="selectgroup-input @error('form.type') is-invalid
                                @enderror" wire:model="form.type" checked>
                                <span class="selectgroup-button">Produit</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="type" value="Service" class="selectgroup-input @error('form.type') is-invalid
                                @enderror" wire:model="form.type">
                                <span class="selectgroup-button">Service</span>
                            </label>
                            @error('form.type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Taxe</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">Taxe</div>
                            </div>
                            <select class="form-control @error('form.taxe') is-invalid
                                @enderror" wire:model="form.taxe" id="exampleFormControlSelect1">
                                <option value="Homme">Selectionner une taxe</option>
                                @foreach ($tva as $item)
                                    <option value="{{$item->valeur}}">{{$item->valeur}}</option>
                                @endforeach
                            </select>
                            @error('form.taxe')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                @if (Auth()->user()->entreprise->nom !== "Demo")
                    <div class="mb-4">
                        @if ($status !=="editProduct")
                            <button type="reset" class="btn btn-warning">Annuler</button>&nbsp;&nbsp;
                        @endif
                        <button type="submit" class="btn btn-success">
                            @if ($status ==="editProduct")
                                Modifier
                            @else
                                Ajouter
                            @endif
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
