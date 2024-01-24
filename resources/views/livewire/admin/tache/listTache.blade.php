<div class="card mt-2 card-primary">
    <div class="card-body">
        <div class="section-title mt-0"><strong>Liste des Tâches</strong></div>
        <div class="table-responsive">
            <table class="table table-hover" id="table-2">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Assignation</th>
                    <th>Date début</th>
                    <th>Date Fin</th>
                    <th>Priorité</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($taches as $tache)
                    <tr>
                        <td>{{$tache->titre}}</td>
                        <td>{{$tache->employe->prenom}} {{$tache->employe->nom}}</td>
                        <td>{{ date("d/m/Y", strtotime($tache->date_debut))}}</td>
                        <td>{{ date("d/m/Y", strtotime($tache->date_fin))}}</td>
                        <td>
                            <div class="text-small font-weight-600
                                @if ($tache->priorite==='Urgent')
                                    text-success
                                @elseif($tache->priorite==='Haute')
                                    text-info
                                @elseif($tache->priorite==='Moyen')
                                    text-warning
                                @elseif($tache->priorite==='Faible')
                                    text-light
                                @else
                                    text-secondary
                                @endif">
                                <i class="fas fa-circle"></i> {{$tache->priorite}}
                            </div>
                        </td>
                        <td>
                            <div style="position: relative;
                                top: -1px;" class="badge badge-warning
                                @if ($tache->statut==='Terminé')
                                    bg-success
                                @elseif($tache->statut==='En cours')
                                    bg-warning
                                @else
                                    bg-danger
                                @endif">{{$tache->statut}}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex">
                                <button  class="btn btn-icon btn-outline-info btn-sm" wire:click.prevent="getTache({{$tache->id}})"><i class="far fa-eye"></i></button>
                                @if (Auth()->user()->entreprise->nom !== "Demo") 
                                    @if (Auth()->user()->isAdmin())
                                        <button  class="btn ml-1 btn-icon btn-outline-danger btn-sm
                                        trigger--fire-modal-1" wire:click.prevent="delete({{$tache->id}})" data-confirm-yes="remove()"><i class="fa fa-trash"></i></button>
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

