<div>
    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-3">
          <div class="card profile-widget card-primary">
            <div class="profile-widget-header">
                @if ($profil)
                <img alt="image" height="80" width="80" src="{{$profil->temporaryUrl()}}" class="rounded-circle profile-widget-picture">
                @else
                <img alt="image" height="80" width="80" src="storage/images/{{ $user->profil}}" class="rounded-circle profile-widget-picture">
              @endif
              
            </div>
            <div class="profile-widget-description">
                <div class="profile-widget-name">{{ $user->prenom}} {{ $user->nom}}
                    <div class="text-muted d-inline font-weight-normal">
                      <div class="slash"></div> {{ $user->role}}
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <div class="input-group mb-3">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" wire:model="profil" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                      <label class="custom-file-label" for="inputGroupFile01">Choisir</label>
                      <div wire:loading wire:target="profil">Chargement...</div>
                    </div>
                </div>
                <button class="btn btn-icon icon-left btn-success" wire:click.prevent="editProfil">Changer</button>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-12 col-lg-9">
          <div class="card card-primary">
            <div class="card-header">
                <h4>Information du profil</h4>
              </div>
              <div class="card-body">
                  @include('livewire.superAdmin.users.addUser')
            </div>
          </div>
        </div>
    </div>


</div>


@section('js')
<script>

    window.addEventListener('updateSuccessful', event =>{
        iziToast.success({
        title: 'Utilisateur',
        message: 'Mis à jour avec succes',
        position: 'topRight'
        });
    });

    window.addEventListener('profilEditSuccessful', event =>{
        iziToast.success({
        title: 'Image Profil',
        message: 'Mis à jour avec succes',
        position: 'topRight'
        });
        location.reload();
    });

</script>

@endsection
