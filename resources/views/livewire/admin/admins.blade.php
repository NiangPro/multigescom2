<div>
    <div class="card card-primary">
        <div class="card-header">
          <h4>{{ $title }}</h4>
          <div class="card-header-action">
            <div class="btn-group">
                @if( $etat!== "info")
                    {{-- @if (Auth()->user()->entreprise->nom !== "Demo") --}}
                        <button class="btn @if( $etat=== "add") btn-success @else btn-primary @endif " wire:click.prevent="changeEtat('add')"><i class="fa fa-plus"></i>  @if ($etat === "add" || $etat === "exist") Nouveau @elseif($etat === "list") Ajout @endif </button>
                    {{-- @endif --}}
                @endif
                @if ($etat === "add" || $etat === "exist")
                    <button  class="btn @if( $etat=== "exist") btn-success @else btn-primary @endif"  wire:click.prevent="changeEtat('exist')"><i class="fas fa-male"></i> Existant</button>
                @endif
                <button  class="btn @if( $etat=== "list") btn-success @else btn-primary @endif"  wire:click.prevent="changeEtat('list')"><i class="fa fa-list-alt"></i> Liste</button>
            </div>
          </div>
        </div>
        <div class="card-body">
            @if ($etat === "add" || $etat === "exist")
                @include('livewire.admin.administrateur.addAdmin')
            @elseif($etat === "list")
                @include('livewire.admin.administrateur.listAdmin')
            @elseif($etat==="info")
                @include('livewire.admin.administrateur.infoAdmin')
            @endif
        </div>
</div>

@section('js')
<script>
    window.addEventListener('sexEmpty', event =>{
        iziToast.error({
        title: 'Comptable',
        message: 'Veuillez choisir un sexe',
        position: 'topRight'
        });
    });

    window.addEventListener('adminNoCompany', event =>{
        iziToast.error({
        title: 'Administrateur',
        message: 'Veulliez choisir une entreprise pour les administrateur',
        position: 'topRight'
        });
    });

    window.addEventListener('addSuccessful', event =>{
        iziToast.success({
        title: 'Admin',
        message: 'Ajout avec succes',
        position: 'topRight'
        });
    });

    window.addEventListener('updateSuccessful', event =>{
        iziToast.success({
        title: 'Admin',
        message: 'Mis à jour avec succes',
        position: 'topRight'
        });
    });

    window.addEventListener('profilEditSuccessful', event =>{
        iziToast.success({
        title: 'Profil Admin',
        message: 'Mis à jour avec succes',
        position: 'topRight'
        });
        location.reload();
    });

    window.addEventListener('passwordEditSuccessful', event =>{
        iziToast.success({
        title: 'Mot de passe',
        message: 'Mis à jour avec succes',
        position: 'topRight'
        });
    });


</script>

@endsection
