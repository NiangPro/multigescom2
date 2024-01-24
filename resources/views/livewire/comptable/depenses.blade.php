<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    @if ($etat ==="list")
        <button wire:click.prevent="changeEtat('add')" class="btn btn-primary mb-2" > <i class="fa fa-plus" aria-hidden="true"></i> Ajout</button>
    @endif
    @if ($etat ==="add" || $etat ==="info")
        @include('livewire.comptable.depense.addDepense')
    @else
        @include('livewire.comptable.depense.listDepense')
    @endif
</div>


@section('js')
    <script>

        window.addEventListener('addSuccessful', event =>{
            iziToast.success({
            title: 'Depense',
            message: 'Ajout avec succes',
            position: 'topRight'
            });
        });

        window.addEventListener('updateSuccessful', event =>{
            iziToast.success({
            title: 'Depense',
            message: 'Mis à jour avec succes',
            position: 'topRight'
            });
        });
        
    </script>
@endsection