<div>
    <div class="card card-primary">
        <form wire:submit.prevent="editConfig"  class="needs-validation" novalidate="">
          <div class="card-header">
            <h4>Personnalisation de l'application</h4>
          </div>
          <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-8 form-group">
                                <label for="">Logo de l'entreprise</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('logo')
                                    is-invalid
                                @enderror" id="validatedCustomFile" wire:model="logo">
                                    <label class="custom-file-label" for="validatedCustomFile">Logo...</label>
                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                    <div wire:loading wire:target="logo">Chargement...</div>
                                    @error('icon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">

                                @if ($logo)
                                    <img src="{{$logo->temporaryUrl()}}" alt="" height="90" width="100"  class="shadow-light rounded-circle">
                                @else
                                    <img src="{{asset('storage/images/'.$data['logo'])}}" alt="logo" width="100" height="90" class="shadow-light rounded-circle">
                                @endif


                            </div>
                        </div>
                    </div>
                    @if (Auth()->user()->role === 'Super Admin')

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-8 form-group">
                                <label for="">Favicon de l'entreprise</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('icon')
                                    is-invalid
                                @enderror" wire:model="icon" id="validatedCustomFile">
                                    <label class="custom-file-label" for="validatedCustomFile">Favicon...</label>
                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                    <div wire:loading wire:target="icon">Chargement...</div>
                                    @error('icon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">

                                @if ($icon)
                                    <img src="{{$icon->temporaryUrl()}}" alt="" height="90" width="100" class="shadow-light rounded-circle">
                                @else
                                    <img src="{{asset('storage/images/'.$data['icon'])}}" alt="icon" width="100" height="90" class="shadow-light rounded-circle">
                                @endif

                            </div>
                        </div>
                    </div>

                    @endif
                    <div class="form-group col-md-6">
                            <label for="inputEmail4">Nom de l'application</label>
                            <input type="text" class="form-control @error('name')
                                is-invalid
                            @enderror" id="inputEmail4" wire:model="name" placeholder="Nom de l'application">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                    <div class="col-md-4 mt-4 pt-1">
                        <button type="submit" class="btn btn-icon icon-left btn-success"><i class="far fa-edit"></i>
                            Modifier</button>
                    </div>
                </div>
          </div>
        </form>
      </div>
</div>


@section('js')
<script>
     window.addEventListener('editSuccessfulAdmin', event =>{
        iziToast.success({
        title: 'Configuration du systeme',
        message: 'Mis à jour avec succes',
        position: 'topRight'
        });

        location.reload();

    });



</script>

@endsection
