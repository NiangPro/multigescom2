<div class="row">
    <div class="col-md-5">
        <h3>Statut : @if ($entreprise->statut === 1)
            <span class="text-success"><i class="fa fa-lock-open" aria-hidden="true"></i> Ouvert</span>
        @else
            <span class="text-danger"><i class="fa fa-lock" aria-hidden="true"></i> Fermé</span>

        @endif</h3>
        @if ($profil)
            <img src="{{$profil->temporaryUrl()}}" alt="" height="250" width="300">
        @else
            <img src="{{asset('storage/images/'.$entreprise->profil)}}" alt="" height="250" width="300">
        @endif
        <div class="input-group mb-3 mt-3">
            <div class="custom-file">
              <input type="file" class="custom-file-input" wire:model="profil" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
              <label class="custom-file-label" for="inputGroupFile01">Choisir</label>
              <div wire:loading wire:target="profil">Chargement...</div>
            </div>
        </div>
        <button class="btn btn-icon icon-left btn-success" wire:click.prevent="editProfil">Changer</button>

    </div>
    <div class="col-md-7">
        <h4 class="m-2">Information de {{$entreprise->nom}}</h4>
        @include('livewire.superAdmin.company.addCompany')
    </div>
</div>
<hr>

    <h4>
        @if (count($entreprise->users) > 0)
            Liste des administrateurs de {{$entreprise->nom}}
        @else
            Aucun administrateur pour le moment
        @endif
    </h4>
<div class="row">
    @foreach ($entreprise->users as $user)
        @if ($user->role === "Admin")
            <div class="col-12 col-md-12 col-lg-4">
            <div class="card profile-widget card-primary">
            <div class="profile-widget-header">
                <img alt="image" height="80" width="80" src="storage/images/{{ $user->profil}}" class="rounded-circle profile-widget-picture">
            </div>
            
            <div class="profile-widget-description">
                <div class="profile-widget-name"> {{ $user->prenom}} {{ $user->nom}}
                    <button class="float-right btn-primary btn-sm rounded-circle" wire:click.prevent="userMessage({{$user->id}})">
                        <i class="far fa-paper-plane"></i>
                    </button>
                    <div class="text-muted d-inline font-weight-normal">
                        {{-- <div class="slash"></div> --}}
                        <br><i class="fa fa-phone" aria-hidden="true"></i> {{ $user->tel}}
                        <br><i class="fa fa-envelope" aria-hidden="true"></i> {{ $user->email}}
                    </div>
                </div>
            </div>
            </div>
        </div>
                
        @endif
    @endforeach
</div>
