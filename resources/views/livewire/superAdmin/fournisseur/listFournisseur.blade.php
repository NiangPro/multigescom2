<div class="card mt-2 card-primary">
    <div class="card-body">
        <div class="section-title mt-0"><strong>Liste des Fournisseurs</strong></div>
        <div class="table-responsive">
            <table class="table table-hover" id="table-2">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Pays</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fournisseurs as $item)
                    <tr>
                        <td>{{$item->nom}}</td>
                        <td>{{$item->adresse}}</td>
                        <td>{{$item->tel}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{$item->pays->nom_fr}}</td>
                        <td>
                            <div class="d-flex">
                                <button  class="btn btn-icon btn-outline-info btn-sm" wire:click.prevent="getFournisseur({{$item->id}})"><i class="far fa-eye"></i></button>
                                @if (Auth()->user()->entreprise->nom !== "Demo")
                                    <button  class="btn ml-1 btn-icon btn-outline-danger btn-sm  
                                    trigger--fire-modal-1" wire:click.prevent="delete({{$item->id}})" data-confirm-yes="remove()"><i class="fa fa-trash"></i></button>
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

