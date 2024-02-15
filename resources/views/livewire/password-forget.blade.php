<div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form wire:submit.prevent="connecter"  class="sign-in-form">
          <h4 class="title">Mot de passe oublié</h4>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="email" wire:model="form.email" placeholder="Email" required/>
          </div>
          <input type="submit" value="Envoyer" class="btn solid" />
          <a href="{{route('login')}}"   >Connexion</a>
          
        </form>
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
          message: 'Email ou mot de passe incorrect',
          position: 'topRight'
          });
      })

      window.addEventListener('accessDenied', event =>{
          iziToast.error({
          title: 'Connexion',
          message: 'Votre espace est fermé, Veuillez renouveler votre abonnement svp!',
          position: 'topRight'
          });
      })
  </script>

  @endsection
