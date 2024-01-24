<div class="card card-primary mt-3">
    <div class="card-header">
        <h4>
            @if ($statut === "add")
               Ajout document
            @endif
        </h4>
        <span class="btn-list">
            <button wire:click.prevent="changeStatut('list')" class="btn back-info btn-outline-primary">
                <i class="fa fa-list" aria-hidden="true"></i> Liste document(s)</button>
        </span>
    </div>
    <div class="card-body container col-8 mb-2">
        <form wire:submit.prevent="addDocument">
            <div class="form-group">
                <div class="label">Nom du fichier</div>
                <input type="text" class="form-control @error('contratForm.titre') is-invalid @enderror" wire:model="contratForm.titre" >
                @error('contratForm.titre')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <div class="custom-file">
                    <div class="label">fichier</div>
                    <input type="file" class="custom-file-input @error('contratForm.fichier') is-invalid @enderror" wire:model="contratForm.fichier"  wire:model="contratForm.fichier" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">Choisir</label>
                    <div wire:loading wire:target="contratForm.fichier" class="text-success">Chargement...</div>
                    @error('contratForm.fichier')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            @if (Auth()->user()->entreprise->nom !== "Demo")
                <div>
                    <button type="reset" class="btn btn-warning">Annuler</button>&nbsp;&nbsp;
                    <button type="submit" class="btn btn-success">Ajouter</button>
                </div>
            @endif
        </form>
    </div>
</div>
