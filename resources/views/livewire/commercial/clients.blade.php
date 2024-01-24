<div>
    @if ($status ==='listClients')
        <button wire:click.prevent="changeEtat('addClient')" class="btn btn-primary mb-2" > <i class="fa fa-plus" aria-hidden="true"></i> Ajout</button>
    @endif
    @if ($status ==="addClient")
        @include('livewire.commercial.client.add')
    @elseif($status ==="listClients")
        @include('livewire.commercial.client.listClients')
    @elseif($status ==="editClient")
        @include('livewire.commercial.client.add')
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

    window.addEventListener('deleteSuccessful', event =>{
            iziToast.success({
            title: 'Client',
            message: 'Suppression avec succes',
            position: 'topRight'
            });

            $('#message').hide();
        });

</script>

@endsection
