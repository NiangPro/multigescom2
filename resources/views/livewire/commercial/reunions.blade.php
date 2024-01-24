<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
   
    <button wire:click.prevent="changeEtat('addReunion')" class="btn btn-primary mb-2" > <i class="fa fa-plus" aria-hidden="true"></i> Ajout</button>
    @if ($status ==="addReunion")
        @include('livewire.commercial.reunion.addReunion')
    @elseif($status ==="listReunions")
        @include('livewire.commercial.reunion.listReunions')
    @elseif($status ==="editReunion")
        @include('livewire.commercial.reunion.addReunion')
    @endif
</div>


@section('js')
    <script>

        window.addEventListener('addSuccessful', event =>{
            iziToast.success({
            title: 'Reunion',
            message: 'Ajout avec succes',
            position: 'topRight'
            });
        });

        window.addEventListener('updateSuccessful', event =>{
            iziToast.success({
            title: 'Reunion',
            message: 'Mis à jour avec succes',
            position: 'topRight'
            });
        });

    </script>
@endsection
