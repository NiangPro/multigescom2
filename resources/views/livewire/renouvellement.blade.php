<div class="container card col-md-6 p-5">

  <h5>Renouvellement</h5>
  <form wire:submit.prevent='payer'>
    <div class="form-group row">
      <label for="inputEmail3" class="col-sm-3 col-form-label">Option</label>
      <div class="col-sm-7">
        <select class="custom-select mr-sm-2" wire:change='changeAbmt' wire:model='formAbmt.type' id="inlineFormCustomSelect">
          <option value="mois" selected>Mois</option>
          <option value="annee">Année</option>
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label for="inputEmail3" class="col-sm-3 col-form-label">Durée</label>
      <div class="col-sm-7">
        <input type="number" min="0"  wire:model='formAbmt.nombre' wire:change='changeAbmt' class="form-control" id="inputEmail3">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputEmail3" class="col-sm-5 h6 col-form-label">Montant Total:</label>
      <div class="col-sm-7">
        <h5>{{ number_format($total, 0, ',' , ' ') }} FCFA</h5>
      </div>
    </div>
    <button type="submit" class="btn btn-success">Renouveler</button>
    <button type="button" wire:click='resetRenew' class="btn btn-warning">Annuler</button>
  </form>
</div>