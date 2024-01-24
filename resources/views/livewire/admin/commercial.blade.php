<div>
    <div class="card card-primary">
        <div class="card-header">
          <h4>{{ $title }}</h4>
          <div class="card-header-action">
            <div class="btn-group">
                    @if( $etat!== "info")
                        <button  class="btn @if( $etat=== "add") btn-success @else btn-primary @endif " wire:click.prevent="changeEtat('add')"><i class="fa fa-plus"></i>  @if ($etat === "add" || $etat === "exist") Nouveau @elseif($etat === "list") Ajout @endif </button>
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
                @include('livewire.admin.commerciaux.addCommercial')
            @elseif($etat === "list")
                @include('livewire.admin.commerciaux.listCommercial')
            @elseif($etat==="info")
                @include('livewire.admin.commerciaux.infoCommercial')
            @endif
        </div>
</div>

@section('js')
<script>
    window.addEventListener('sexEmpty', event =>{
        iziToast.error({
        title: 'Commercial',
        message: 'Veuillez choisir un sexe',
        position: 'topRight'
        });
    });

    window.addEventListener('adminNoCompany', event =>{
        iziToast.error({
        title: 'Commercial',
        message: 'Veulliez choisir une entreprise pour les commerciaux',
        position: 'topRight'
        });
    });

    window.addEventListener('addSuccessful', event =>{
        iziToast.success({
        title: 'Commercial',
        message: 'Ajout avec succes',
        position: 'topRight'
        });
    });

    window.addEventListener('updateSuccessful', event =>{
        iziToast.success({
        title: 'Commercial',
        message: 'Mis à jour avec succes',
        position: 'topRight'
        });
    });

    window.addEventListener('profilEditSuccessful', event =>{
        iziToast.success({
        title: 'Profil Commercial',
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
