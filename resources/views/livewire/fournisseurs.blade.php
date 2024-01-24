<div>
    @if ($status ==="listFournisseurs")
        <button wire:click.prevent="changeEtat('addFournisseur')" class="btn btn-primary mb-2" > <i class="fa fa-plus" aria-hidden="true"></i> Ajout</button>
    @endif
    @if ($status ==="addFournisseur")
        @include('livewire.superAdmin.fournisseur.add')
    @elseif($status ==="listFournisseurs")
        @include('livewire.superAdmin.fournisseur.listFournisseur')
    @elseif($status ==="editFournisseur")
        @include('livewire.superAdmin.fournisseur.add')
    @endif
</div>

@section('js')
<script>

    window.addEventListener('addSuccessful', event =>{
        iziToast.success({
        title: 'Client',
        message: 'Ajout avec succes',
        position: 'topRight'
        });
    });

    window.addEventListener('updateSuccessful', event =>{
        iziToast.success({
        title: 'Client',
        message: 'Mis à jour avec succes',
        position: 'topRight'
        });
    });

</script>

@endsection
