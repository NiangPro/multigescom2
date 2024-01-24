<div>

    <div class="card card-primary">
        <div class="card-header">
          <h4>{{ $title }}</h4>
          <div class="card-header-action">
            <div class="btn-group">
                <button  class="btn @if( $etat=== "superAdmin") btn-success @else btn-primary @endif " wire:click.prevent="superAdmin">Super Admin</button>
                <button class="btn @if( $etat=== "admin") btn-success @else btn-primary @endif" wire:click.prevent="admin">Admin</button>
                <button  class="btn @if( $etat=== "add") btn-success @else btn-primary @endif"  wire:click.prevent="add">Ajout</button>
            </div>
          </div>
        </div>
        <div class="card-body">
            @if ($etat === "add")
                @include('livewire.superAdmin.users.addUser')
            @elseif($etat === "superAdmin")
                @include('livewire.superAdmin.users.listSuperAdmin')
            @elseif($etat === "info")
                @include('livewire.superAdmin.users.infoUser')
            @else
                @include('livewire.superAdmin.users.listAdmin')
            @endif
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

     window.addEventListener('haveNotService', event =>{
        iziToast.error({
        title: 'Utilisateur',
        message: 'Les super admins n\'appartiennent à aucune entreprise',
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
