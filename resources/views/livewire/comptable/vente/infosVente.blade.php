<div class="card mt-2 card-primary">
    <div class="d-inline-block mr-4 ml-4 mt-5">
        <div class="float-left">
            <button class="btn btn-icon icon-right btn-warning" type="button" wire:click="changeEtat('list')"><i class="fas fa-arrow-left"></i> Retour</button>
            <button wire:click.prevent="store" onclick="printDiv('detailsVente')" class="btn btn-icon icon-right btn-success ml-2"><i class="fas fa-file-invoice"></i> Imprimer</button>                
        </div>
        <div class="float-right" id> <h3 class="mb-0">Vente</h3></div>
    </div><hr>
    <div class="card-body container mt-0" id="detailsVente">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-center">Facture fait le {{ date("d/m/Y", strtotime($this->current_vente->ventes->date))}}</h4>
            </div>
        </div>
        <div class="row mb-4 mt-3">
            <div class="col-md-6 col-sm-6">
                <h5 class="mb-3">De:</h5>
                <img class="mr-2 mb-2" width="130" src="{{asset('storage/images/'.Auth()->user()->entreprise->profil)}}" alt="logo">
                <h3 class="text-dark mb-1">{{Auth()->user()->entreprise->nom}}</h3>
                <div>Adresse: {{Auth()->user()->entreprise->adresse}}</div>
                <div>Tel: {{Auth()->user()->entreprise->tel}}</div>
                <div>Responsable: {{Auth()->user()->prenom}} {{Auth()->user()->nom}}</div>
            </div>
            <div class="col-md-6 col-sm-6">
                <span class="float-right mr-3">
                    <span class="d-flex">
                        <h5 class="mb-3 text-uppercase">
                            <h3 class="mb-1 text-dark">à: {{$this->current_vente->ventes->client->nom}}</h3>
                        </h5>
                    </span>
                    <div>Adresse: {{$this->current_vente->ventes->client->adresse}}</div>
                    <div>Tel: {{$this->current_vente->ventes->client->tel}}</div>
                    <div>Email: {{$this->current_vente->ventes->client->email}}</div>
                </span>
            </div>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produit / Service</th>
                        <th>Description</th>
                        <th class="right">Prix</th>
                        <th class="center">Quantité</th>
                        <th class="right">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="left strong">{{$this->current_vente->nom}}</td>
                        <td class="left">{{$this->current_vente->description}}</td>
                        <td class="right">{{$this->current_vente->montant}} CFA</td>
                        <td class="center">{{$this->current_vente->quantite}}</td>
                        <td class="right">{{$this->mtHt}} CFA</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-5"></div>
            <div class="col-lg-4 col-sm-5 ml-auto">
                <table class="table">
                    <tbody>
                        <tr style="border-bottom: 1px solid black;">
                            <td class="left" >
                                <strong class="text-dark ml-n4">Remise</strong>
                            </td>
                            <td class="right">{{$this->current_vente->ventes->remise}}%</td>
                        </tr>
                        <tr style="border-bottom: 1px solid black;">
                            <td class="left">
                                <strong class="text-dark ml-n4">Total</strong>
                            </td>
                            <td class="right">
                                <strong class="text-dark">{{$this->current_vente->ventes->montant}} CFA</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>