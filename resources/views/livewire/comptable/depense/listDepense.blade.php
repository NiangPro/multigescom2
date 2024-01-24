<div class="card mt-2 card-primary">
    <div class="card-body">
        <div class="section-title mt-0"><strong>Liste des Dépenses</strong></div>
        <div class="table-responsive">
            <table class="table table-hover" id="table-2">
            <thead>
                <tr>
                    <th>Categorie</th>
                    <th>Mode de paiement</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Montant</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($depenses as $depense)
                    <tr>
                        <td>{{$depense->categorie}}</td>
                        <td>
                            <div class="text-small font-weight-600
                                @if ($depense->mode_paiement==='Wave')
                                    text-primary
                                @elseif($depense->mode_paiement==='Orange Money')
                                    text-warning
                                @elseif($depense->mode_paiement==='En espèces')
                                    text-info
                                @elseif($depense->mode_paiement==='Chèque')
                                    text-dark
                                @else
                                    text-muted
                                @endif">
                                <i class="fas fa-circle"></i> {{$depense->mode_paiement}}
                        
                        </td>
                        <td>{{ date("d/m/Y", strtotime($depense->date))}}</td>
                        <td>{{$depense->description}}</td>
                        <td>{{$depense->montant}} CFA</td>
                        <td>
                            <div class="d-flex">
                                <button  class="btn btn-icon btn-outline-info btn-sm" wire:click.prevent="getDepense({{$depense->id}})"><i class="far fa-eye"></i></button>
                                @if (Auth()->user()->entreprise->nom !== "Demo")
                                    @if (Auth()->user()->isAdmin())
                                    <button  class="btn ml-1 btn-icon btn-outline-danger btn-sm
                                    trigger--fire-modal-1" wire:click.prevent="delete({{$depense->id}})" data-confirm-yes="remove()"><i class="fa fa-trash"></i></button>
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

