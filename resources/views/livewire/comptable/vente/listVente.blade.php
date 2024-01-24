<div class="card mt-2 card-primary">
    <div class="card-body">
        <div class="section-title mt-0"><strong>Liste des Ventes</strong></div>
        <div class="table-responsive">
            <table class="table table-hover" id="table-2">
            <thead>
                <tr>
                    <th>Produit / Service</th>
                    <th>Montant Total</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Employé</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venteItem as $vente)
                    <tr>
                        <td class="text-dark strong">{{$vente->nom}}</td>
                        <td>{{$vente->ventes->montant}} CFA</td>
                        <td>{{$vente->ventes->client->nom}}</td>
                        <td>{{date("d/m/Y", strtotime($vente->ventes->date))}}</td>
                        <td>{{$vente->ventes->employe->prenom}} {{$vente->ventes->employe->nom}}</td>
                        <td>
                            <div class="d-flex">
                                <button  class="btn btn-icon btn-outline-info btn-sm" wire:click.prevent="getVentes({{$vente->id}})"><i class="far fa-eye"></i></button>
                                @if (Auth()->user()->entreprise->nom !== "Demo")
                                    @if (Auth()->user()->isAdmin())
                                        <button  class="btn ml-1 btn-icon btn-outline-danger btn-sm
                                        trigger--fire-modal-1" wire:click.prevent="delete({{$vente->id}})" data-confirm-yes="remove()"><i class="fa fa-trash"></i></button>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
</div>

