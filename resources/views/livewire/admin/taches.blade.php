<div>
    {{-- Care about people's approval and you will be their prisoner. --}}

    <button wire:click.prevent="changeEtat('addTache')" class="btn btn-primary mb-2" > <i class="fa fa-plus" aria-hidden="true"></i> Ajout</button>
    @if ($status ==="addTache"  || $status ==="editTache")
        @include('livewire.admin.tache.addTache')
    @else
        @include('livewire.admin.tache.listTache')
    @endif
</div>


@section('js')
    <script>

        window.addEventListener('addSuccessful', event =>{
            iziToast.success({
            title: 'Tâche',
            message: 'Ajout avec succes',
            position: 'topRight'
            });
        });

        window.addEventListener('updateSuccessful', event =>{
            iziToast.success({
            title: 'Tâche',
            message: 'Mis à jour avec succes',
            position: 'topRight'
            });
        });

    </script>
@endsection
