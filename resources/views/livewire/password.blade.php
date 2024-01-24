<div>
    <div class="card card-primary">
        <form wire:submit.prevent="editPassword"  class="needs-validation" novalidate="">
          <div class="card-header">
            <h4>Reinitialisation du mot de passe</h4>
          </div>
          <div class="card-body">
              <div class="row">
                  <div class="col-md-4">
                      <div class="form-group">
                          <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">Actuel<span class="text-danger">*</span></div>
                            </div>
                            <input type="password" class="form-control @error('form.current_password') is-invalid @enderror" wire:model="form.current_password" placeholder="Le mot de passe actuel">
                            @error('form.current_password')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">Nouveau<span class="text-danger">*</span></div>
                          </div>
                          <input type="password" class="form-control @error('form.password') is-invalid @enderror" wire:model="form.password" placeholder="Nouveau mot de passe">
                          @error('form.password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                  <div class="col-md-4">
                      <div class="form-group">
                          <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">Confirmation<span class="text-danger">*</span></div>
                            </div>
                            <input type="password" class="form-control @error('form.password_confirmation') is-invalid @enderror" wire:model="form.password_confirmation" placeholder="Mot de passe de confirmation">
                            @error('form.password_confirmation')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                          </div>
                      </div>
                  </div>
                  
                  
                </div>
                <button type="submit" class="btn btn-icon icon-left btn-success"><i class="far fa-edit"></i>Modifier</b>
  
          </div>
        </form>
      </div>
</div>


@section('js')
<script>
     window.addEventListener('passwordNotFound', event =>{
        iziToast.error({
        title: 'Mot de passe actuel',
        message: 'Verifiez le mot de passe actuel',
        position: 'topRight'
        });
    });

    window.addEventListener('passwordEditSuccessful', event =>{
        iziToast.success({
        title: 'Mot de passe',
        message: 'Mis à jour avec succes',
        position: 'topRight'
        });
    });

</script>

@endsection