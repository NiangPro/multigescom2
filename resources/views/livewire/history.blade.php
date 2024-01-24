<div>

    <div class="card card-primary">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table-2">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Utilisateurs</th>
                        <th>Rôles</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historiques as $histo)
                        <tr>
                            <td>
                                {{ date("d/m/Y à H:i:s ", strtotime($histo['date']))}}
                            </td>
                            <td>{{$histo['description']}}</td>
                            <td>{{$histo['user']->prenom}} {{$histo['user']->nom}}</td>
                            <td>{{$histo['user']->role}}</td>
                            <td>
                                @if ($histo['type'] === 'add')
                                    <button  class="btn btn-icon btn-success btn-sm" title="Ajout"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    @elseif ($histo['type'] === 'update')
                                    <button  class="btn btn-icon btn-warning btn-sm" title="Mis à jour"><i class="far fa-edit"></i></button>
                                    @else
                                    <button  class="btn btn-icon btn-danger btn-sm" title="Suppression"><i class="fa fa-trash" aria-hidden="true"></i></button>

                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
</div>

@section('js')
<script>
    window.addEventListener('sexEmpty', event =>{
        iziToast.error({
        title: 'Utilisateur',
        message: 'Veuillez choisir un sexe',
        position: 'topRight'
        });
    });
    window.addEventListener('adminNoCompany', event =>{
        iziToast.error({
        title: 'Utilisateur',
        message: 'Veulliez choisir une entreprise pour les admins',
        position: 'topRight'
        });
    });

    window.addEventListener('addSuccessful', event =>{
        iziToast.success({
        title: 'Utilisateur',
        message: 'Ajout avec succes',
        position: 'topRight'
        });
    });

    window.addEventListener('updateSuccessful', event =>{
        iziToast.success({
        title: 'Utilisateur',
        message: 'Mis à jour avec succes',
        position: 'topRight'
        });
    });

    window.addEventListener('passwordEditSuccessful', event =>{
        iziToast.success({
        title: 'Mot de passe',
        message: 'Mis à jour avec succes',
        position: 'topRight'
        });
    });

    window.addEventListener('profilEditSuccessful', event =>{
        iziToast.success({
        title: 'Utilisateur',
        message: 'Mis à jour avec succes',
        position: 'topRight'
        });
        location.reload();
    });

</script>

@endsection
