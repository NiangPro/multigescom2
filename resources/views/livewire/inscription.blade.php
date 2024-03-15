<div class="card">
    <div class="card-body">
        <form wire:submit.prevent="inscrire" style="display:flex; margin:auto; justify-content:center; margin-top:50px;">
            <h2 class="title">Inscription</h2>
            <div style="display: inline-flex; flex-direction: row; column-gap: 25px; align-items: center;">
                <div class="">
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="prenom" class=" @error('form.prenom') is-invalid @enderror" wire:model="form.prenom" placeholder="Prénom" required style="width: 400px;"/>
                        @error('form.nom')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="nom" class=" @error('form.nom') is-invalid @enderror" wire:model="form.nom" placeholder="Nom" required style="width: 400px;"/>
                        @error('form.nom')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div>
                <div class="input-field" style="max-width:100%">
                    <i class="fas fa-envelope"></i>
                    <input type="email" class=" @error('form.email') is-invalid @enderror" wire:model="form.email" placeholder="email" required style="width: 755px!important;"/>
                    @error('form.email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div style="display: inline-flex; flex-direction: row; column-gap: 44px; align-items: center;">
                <div>
                    <div class="form-group" style="margin-left: 77px;">
                        <div class="selectgroup selectgroup-pills" style="display: inline-flex; justify-content: start; float: left; margin-top:4px; 
                        margin-bottom: 4px; margin-left: -50px; color: #aaaaaa; font-weight: 500; font-size: 17px;" >
                            Sexe &nbsp;&nbsp;&nbsp;
                          <label class="selectgroup-item">
                            <input type="radio" name="icon-input" value="Homme" class="selectgroup-input @error('form.sexe') is-invalid @enderror" wire:model="form.sexe" checked="">
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-male"></i></span>
                          </label>&nbsp;&nbsp;&nbsp;
                          <label class="selectgroup-item">
                            <input type="radio" name="icon-input" value="Femme" class="selectgroup-input @error('form.sexe') is-invalid @enderror" wire:model="form.sexe">
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-female"></i></span>
                          </label>
                          @error('form.sexe')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                    </div>
                </div>
                <div>
                    <div class="input-field" style="margin-left:170px;">
                        <i class="fas fa-phone"></i>
                        <input type="tel" class="@error('form.tel') is-invalid @enderror" wire:model="form.tel" placeholder="Téléphone" required style="width: 400px;"/>
                        @error('form.tel')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div style="display: inline-flex; flex-direction: row; column-gap: 25px; align-items: center;">
                <div>
                    <div class="input-field">
                        <i class="fas fa-landmark"></i>
                        <input type="text" class="@error('form2.nom') is-invalid @enderror" wire:model="form2.nom" placeholder="Nom entreprise" required style="width: 400px;"/>
                        @error('form2.nom')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div>
                    <div class="input-field">
                        <i class="fas fa-phone"></i>
                        <input type="tel" wire:model="form2.tel" placeholder="Tél entreprise" required style="width: 400px;"/>
                        @error('form2.tel')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div style="display: inline-flex; flex-direction: row; column-gap: 25px; align-items: center;">
                <div>
                    <div class="input-field">
                        <i class="fas fa-city"></i>
                        <input type="text" class="@error('form2.adresse') is-invalid @enderror" wire:model="form2.adresse" placeholder="Adresse de l'entreprise" required style="width: 400px;"/>
                        @error('form2.adresse')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" class="@error('form2.email') is-invalid @enderror" wire:model="form2.email" placeholder="Email de l'entreprise" required style="width: 400px;"/>
                        @error('form2.email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div style="display: inline-flex; flex-direction: row; column-gap: 25px; align-items: center;">
                <div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="@error('form2.password') is-invalid @enderror" wire:model="form.password" placeholder="Mot de passe" required style="width: 400px;"/>
                        @error('form2.password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="@error('form2.password_confirmation') is-invalid @enderror" wire:model="form.password_confirmation" placeholder="Confirmation" required style="width: 400px;"/>
                        @error('form2.password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <span class="d-flex justify-content-center">
                <input type="submit" value="S'inscrire" class="btn solid" />
                <a href="{{route('login')}}" style="text-decoration: none;">Se connecter</a>
            </span>
            <p class="social-text">Suivez-nous sur les reseaux sociaux</p>
            <div class="social-media" style="margin-bottom: 10px;">
                <a href="https://www.facebook.com/sunucode" target="_blank" class="social-icon">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.tiktok.com/@sunucode?_t=8kfu8GeDS6A&_r=1" target="_blank" class="social-icon">
                    <i class="fab fa-tiktok"></i>
                </a>
                <a href="https://sunucode.com/" target="_blank" class="social-icon">
                    <i class="fas fa-laptop"></i>
                </a>
                <a href="https://www.linkedin.com/company/66938829/admin/feed/posts/" target="_blank" class="social-icon">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </form>
    </div>
</div>

  @section('js')
  <script>
      window.addEventListener('sexEmpty', event =>{
        iziToast.error({
        title: 'Comptable',
        message: 'Veuillez choisir un sexe',
        position: 'topRight'
        });
    });

    window.addEventListener('adminNoCompany', event =>{
        iziToast.error({
        title: 'Administrateur',
        message: 'Veulliez choisir une entreprise pour les administrateur',
        position: 'topRight'
        });
    });

    window.addEventListener('addSuccessful', event =>{
        iziToast.success({
        title: 'S\'inscrire',
        message: 'Inscription avec succes',
        position: 'topRight'
        });
    });

  </script>

  @endsection
