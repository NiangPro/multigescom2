<div class="card mt-2 card-primary">
    <div class="card-body">
        <div class="section-title mt-0"><strong>Liste des Dévis</strong></div>
        <div class="table-responsive">
            <table class="table table-hover" id="table-2">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Produit / Service</th>
                        <th>Montant</th>
                        <th>Date</th>
                        <th>Employé</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devisItem as $dev)
                        <tr>
                            <td class="text-dark strong">
                                {{$dev->client->nom}}
                            </td>
                            <td>
                                @foreach ($dev->devis_items as $item)
                                    {{$item['nom']}} <br>
                                @endforeach
                            </td>
                            <td>{{$dev->montant}} CFA</td>
                            <td>{{ date("d/m/Y", strtotime($dev->date))}}</td>
                            <td>@if($dev->employe) {{$dev->employe->prenom}} {{$dev->employe->nom}} @endif</td>
                            <td>
                                <div class="text-small font-weight-600
                                    @if ($dev->statut==='Envoyé')
                                        text-info
                                    @elseif($dev->statut==='Validé')
                                        text-success
                                    @elseif($dev->statut==='Brouillon')
                                        text-dark
                                    @else
                                        text-muted
                                    @endif">
                                    <i class="fas fa-circle"></i> {{$dev->statut}}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-icon btn-outline-info btn-sm" wire:click.prevent="getDevis({{$dev->id}})"><i class="far fa-eye"></i></button>
                                    @if (Auth()->user()->entreprise->nom !== "Demo")
                                        @if (Auth()->user()->isAdmin())
                                            <button  class="btn ml-1 btn-icon btn-outline-danger btn-sm
                                            trigger--fire-modal-1" wire:click.prevent="delete({{$dev->id}})" data-confirm-yes="remove()"><i class="fa fa-trash"></i></button>
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

