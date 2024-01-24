<div>

    <div class="card card-primary">
        <div class="card-header">
          <h4>{{ $title }}</h4>
          <div class="card-header-action">
            <div class="btn-group">
                @if ($etat === "add" || $etat === "info")
                    <button wire:click.prevent="init" class="btn btn-info">Retour</button>
                @else
                    <button wire:click.prevent="add" class="btn btn-primary">Ajouter</button>
                @endif
            </div>
          </div>
        </div>
        <div class="card-body">

            @if ($etat === "add")

                @include('livewire.superAdmin.company.addCompany')
            @elseif($etat === "info")
                @include('livewire.superAdmin.company.infoCompany')
            @else
                @include('livewire.superAdmin.company.listCompany')
            @endif
        </div>
    </div>
</div>

@section('js')
<script>

    window.addEventListener('addSuccessful', event =>{
        iziToast.success({
        title: 'Entreprise',
        message: 'Ajout avec succes',
        position: 'topRight'
        });
    });

    window.addEventListener('updateSuccessful', event =>{
        iziToast.success({
        title: 'Entreprise',
        message: 'Mis à jour avec succes',
        position: 'topRight'
        });
    });

    window.addEventListener('profilEditSuccessful', event =>{
        iziToast.success({
        title: 'Image Entreprise',
        message: 'Mis à jour avec succes',
        position: 'topRight'
        });
    });

    window.addEventListener('closeSuccessful', event =>{
        iziToast.success({
        title: 'Entreprise',
        message: 'Fermeture avec succes',
        position: 'topRight'
        });
    });

    window.addEventListener('openSuccessful', event =>{
        iziToast.success({
        title: 'Entreprise',
        message: 'Ouverture avec succes',
        position: 'topRight'
        });
    });

    window.addEventListener('deleteSuccessful', event =>{
        iziToast.success({
        title: 'Entreprise',
        message: 'Suppression avec succes',
        position: 'topRight'
        });

        $('#deleteModal').modal('hide');

    });

</script>

@endsection
