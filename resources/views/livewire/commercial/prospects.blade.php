<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    @if ($status ==="listProspects")
        <button wire:click.prevent="changeEtat('addProspect')" class="btn btn-primary mb-2" > <i class="fa fa-plus" aria-hidden="true"></i> Ajout</button>
    @endif
    @if ($status ==="addProspect")
        @include('livewire.commercial.prospects.addProspect')
    @elseif($status ==="listProspects")
        @include('livewire.commercial.prospects.listProspects')
    @elseif($status ==="editProspect")
        @include('livewire.commercial.prospects.addProspect')
    @endif
</div>


@section('js')
    <script>

        window.addEventListener('addSuccessful', event =>{
            iziToast.success({
            title: 'Prospect',
            message: 'Ajout avec succes',
            position: 'topRight'
            });
        });

        window.addEventListener('updateSuccessful', event =>{
            iziToast.success({
            title: 'Prospect',
            message: 'Mis à jour avec succes',
            position: 'topRight'
            });
        });

        window.addEventListener('deleteSuccessful', event =>{
            iziToast.success({
            title: 'Prospect',
            message: 'Suppression avec succes',
            position: 'topRight'
            });

            $('#message').hide();
        });

        window.addEventListener('approveSuccessful', event =>{
            iziToast.success({
            title: 'Prospect',
            message: 'approuvé comme client avec succes',
            position: 'topRight'
            });
        });
        
    </script>
@endsection