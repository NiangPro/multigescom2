<div class="card mt-2 card-primary">
    <div class="card-body">
        <div class="section-title mt-0"><strong>Liste des Prospects</strong></div>
        <div class="table-responsive">
            <table class="table table-hover" id="table-2">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Adresse</th>
                    <th>Email</th>
                    <th>Tel</th>
                    <th>Pays</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prospects as $pros)
                    <tr>
                        <td>{{$pros->nom}}</td>
                        <td>{{$pros->adresse}}</td>
                        <td>{{$pros->email}}</td>
                        <td>{{$pros->tel}}</td>
                        <td>{{$pros->pays->nom_fr}}</td>
                        <td>
                            <div class="d-flex">
                                <button  class="btn btn-icon btn-outline-info btn-sm" wire:click.prevent="getProspect({{$pros->id}})"><i class="far fa-eye"></i></button>
                                @if (Auth()->user()->entreprise->nom !== "Demo")
                                    <button  class="btn ml-1 btn-icon btn-outline-danger btn-sm  
                                    trigger--fire-modal-1" wire:click.prevent="delete({{$pros->id}})" data-confirm-yes="remove()"><i class="fa fa-trash"></i></button>
                                    <button title="definir comme client" class="btn ml-1 btn-icon btn-outline-success btn-sm  
                                    trigger--fire-modal-1" wire:click.prevent="approve({{$pros->id}})">Approuver</button>
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

