<div class="card mt-2 card-primary">
    <div class="card-header">
        <h4>
            Formulaire
            @if ($etat ==="info")
                de modification vente
             @else
                d'ajout vente
            @endif</h4>
        <div class="card-header-action">
          <div class="btn-group">
              <button wire:click.prevent="changeEtat('list')" class="btn btn-primary"><i class="fa fa-list"></i> Liste</button>
          </div>
        </div>
    </div>
    <div class="card-body container mt-0">
        <div class="row mt-4">
            <div class="col-12 col-lg-8 offset-lg-2">
                <div class="wizard-steps text-center">
                    <a class="wizard-step {{ $currentStep != 1 ? 'step1' : 'wizard-step-active' }}">
                        <div class="wizard-step-icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="wizard-step-label">
                            Information vente
                        </div>
                    </a>
                    <a class="wizard-step {{ $currentStep != 2 ? 'step2' : 'wizard-step-active' }}">
                        <div class="wizard-step-icon">
                          <i class="fas fa-file"></i>
                        </div>
                        <div class="wizard-step-label">
                          Bon de commande
                        </div>
                    </a>
                </div>
            </div>
        </div>
          {{-- <form wire:submit.prevent="store" class="wizard-content mt-2"> --}}
            @if ($currentStep === 1)
                <div class="wizard-pane container">
                    @include('livewire.comptable.vente.formVente')
                    <div class="form-group row">
                        <div class="col-lg-4 col-md-6 text-left">
                            <button type="button" class="btn btn-icon icon-right btn-primary" wire:click="firstStepSubmit">Suivant <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            @endif
            @if ($currentStep === 2)
                <div class="wizard-pane">
                    <div class="form-group d-flex" >
                        <select class="form-control" wire:model="idprod" wire:change="changeEvent">
                            <option>Selectionner un produit ou service</option>
                            @foreach ($all_product as $item)
                                <option value="{{$item->id}}">{{$item->nom}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" wire:click.prevent="addItem()" class="btn btn-info float-right mb-1"><i class="fa fa-plus"></i></button>

                        <table class="table table-hover" id="table-2">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Tarif</th>
                                    <th>Quantite</th>
                                    <th>Tva</th>
                                    <th>Montant</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $tab_product as $index => $value)
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for=""></label>
                                                <input readonly type="text" wire:model="tab_product.{{$index}}.nom" placeholder="Nom" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for=""></label>
                                                <input min="1" step="50" wire:change='calculMontant({{$index}})' type="number" wire:model="tab_product.{{$index}}.tarif" placeholder="Montant" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for=""></label>
                                                <input min="1" wire:change='calculMontant({{$index}})' type="number" wire:model="tab_product.{{$index}}.quantite" placeholder="Quantite" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for=""></label>
                                                <input min="1" type="number" wire:change='calculMontant({{$index}})' wire:model="tab_product.{{$index}}.taxe" placeholder="Tva" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for=""></label>
                                                <input min="1" type="number" readonly wire:model="tab_product.{{$index}}.montant" placeholder="Tva" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for=""></label>
                                                <button type="button" class="btn btn-sm btn-danger text-white mt-3"
                                                    wire:click.prevent="removeItem({{$index}})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-group row d-flex justify-content-between" >
                            <div class="col-lg-4 col-md-6"></div>
                            <div class="col-lg-4 col-md-6">
                                <table class="float-right">
                                    <tr class="">
                                        <th class="p-2">Subtotal</th>
                                        <td class="p-2">{{$sous_total}}</td>
                                    </tr>
                                    <tr class="border-t border-gray-300">
                                        <th class="p-2">Remise</th>
                                        <td class="p-2" width="125">
                                            <input type="number" wire:model="remise" name="taxes" class="border border-indigo-500 rounded-md p-1 w-75 d-inline" min="0" max="100" wire:model="taxes">%
                                        </td>
                                    </tr>
                                    <tr class="border-2 border-gray-300 ml-2">
                                        <th>Total</th>
                                        <td>{{$total}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                <div class="col-lg-4 col-md-6 text-left">
                                    <button class="btn btn-icon icon-right btn-warning" type="button" wire:click="back(1)"><i class="fas fa-arrow-left"></i> Retour</button>
                                    <button wire:click.prevent="store" class="btn btn-icon icon-right btn-success ml-2"> Ajouter <i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        
                    </div>
                @endif
          {{-- </form> --}}
    </div>
</div>
