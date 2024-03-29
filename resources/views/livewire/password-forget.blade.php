<div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        @if(!$trouve)
          <form wire:submit.prevent="isExiste"  class="sign-in-form">
            <h4 class="title">Confirmez si c'est vous</h4>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="email" wire:model="form.email" class="@error('form.email') is-invalid @enderror" placeholder="Email" required/>
              @error('form.email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="input-field">
              <i class="fas fa-phone"></i>
              <input type="tel" wire:model="form.tel" class="@error('form.tel') is-invalid @enderror" placeholder="Téléphone" required/>
              @error('form.tel')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <input type="submit" value="Confirmer" class="btn solid" />
            <a href="{{route('login')}}"   >Connexion</a>
            
          </form>
        @else
          <form wire:submit.prevent="editPassword"  class="sign-in-form">
            <h4 class="title">Mot de passe oublié</h4>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" wire:model="form2.password" class="@error('form2.password') is-invalid @enderror" placeholder="Nouveau Mot de passe" required/>
              @error('form2.password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" wire:model="form2.password_confirmation" class="@error('form2.password_confirmation') is-invalid @enderror" placeholder="Confirmer mot de passe" required/>
              @error('form2.password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <input type="submit" value="Envoyer" class="btn solid" />
            <a href="{{route('login')}}"   >Connexion</a>
            
          </form>
        @endif
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Gescom ?</h3>
          <p>
            La gestion commerciale repose sur l'ensemble des tâches liées à
            l'activité commerciale d'une entreprise. Elle permet de définir
            une stratégie visant à fixer ses prix de vente, suivre l'évolution
            des ventes réalisées ainsi que de recueillir des informations sur les
            clients et fournisseurs de l'entreprise.
          </p>

        </div>
        <img src="{{asset('storage/images/login.png')}}" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>One of us ?</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
            laboriosam ad deleniti.
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Connexion
          </button>
        </div>
        <img src="{{asset('storage/images/login.png')}}" class="image" alt="" />
      </div>
    </div>
  </div>
  @section('js')
  <script>
      window.addEventListener('errorLogin', event =>{
          iziToast.error({
          title: 'Connexion',
          message: 'Email ou Téléphone non identique',
          position: 'topRight'
          });
      });

      window.addEventListener('accessDenied', event =>{
          iziToast.error({
          title: 'Connexion',
          message: 'Votre espace est fermé, Veuillez renouveler votre abonnement svp!',
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
