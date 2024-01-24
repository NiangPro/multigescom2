
<div class="table-responsive">
    <table class="table table-striped" id="table-2">
    <thead>
        <tr>
        <th>Profil</th>
        <th>Prenom</th>
        <th>Nom</th>
        <th>Tel</th>
        <th>Email</th>
        <th>Entreprise</th>
        <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($admins as $sa)

        <tr>
            <td>
                <img alt="image" src="{{asset('storage/images/'.$sa->profil)}}" class="rounded-circle" width="35" height="35" data-toggle="tooltip" title="Wildan Ahdian">
            </td>
            <td>{{$sa->prenom}}</td>
            <td>
                {{$sa->nom}}
            </td>
            <td>{{$sa->tel}}</td>
            <td>{{$sa->email}}</td>
            <td>{{$sa->entreprise->nom}}</td>
            <td>
                <button  class="btn btn-icon btn-outline-success btn-sm" wire:click.prevent="info({{$sa->id}})"><i class="far fa-eye"></i></button>
                <button  class="btn btn-icon btn-outline-danger btn-sm " wire:click.prevent="delete({{$sa->id}})"><i class="fa fa-trash"></i></button>
            </td>
        </tr>

        @endforeach
    </tbody>
    </table>
</div>
