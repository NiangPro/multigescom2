<div>
    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-3">
          <div class="card profile-widget card-primary">
            <div class="profile-widget-header">     
                @if ($profil)
                    <img height="80" width="80" src="{{$profil->temporaryUrl()}}" alt="image" class="rounded-circle profile-widget-picture">
                @else
                    <img alt="image" height="80" width="80" src="storage/images/{{ $current_employe->profil}}" class="rounded-circle profile-widget-picture">
                @endif
            </div>
            <div class="profile-widget-description">
                <div class="profile-widget-name">{{ $current_employe->prenom}} {{ $current_employe->nom}}
                    <div class="text-muted d-inline font-weight-normal">
                      <p>{{$current_employe->fonction}}</p>
                    </div>
                </div>
            </div>
            @if (Auth()->user()->entreprise->nom !== "Demo")
                <div class="card-footer text-center mt-n4">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                        <input type="file" class="custom-file-input" wire:model="profil" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputGroupFile01">Choisir</label>
                        {{-- <div wire:loading wire:target="profil">Chargement...</div> --}}
                        </div>
                    </div>
                    <button class="btn btn-icon icon-left btn-success" wire:click.prevent="editProfil">Changer</button>
                </div>
            @endif
          </div>
    
        </div>
        <div class="col-12 col-md-12 col-lg-9">
            @if ($statut === "info")
                @include('livewire.admin.employe.add')
            @elseif($statut === "list")
                @include('livewire.admin.employe.contrat')
            @elseif($statut === "add")
                @include('livewire.admin.employe.addDocument')
            @endif
        </div>
        </div>
    </div>
</div>

@section('js')
<script>

    window.addEventListener('addSuccessful', event =>{
        iziToast.success({
        title: 'Contrat',
        message: 'Ajout avec succes',
        position: 'topRight'
        });
    });

    window.addEventListener('deleteSuccessful', event =>{
        iziToast.success({
        title: 'Document',
        message: 'Suppression avec succes',
        position: 'topRight'
        });

        $('#message').hide();
    });
</script>

@endsection