<div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form wire:submit.prevent="connecter"  class="sign-in-form">
          <h2 class="title">Connexion</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="email" wire:model="form.email" placeholder="Email" required/>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" wire:model="form.password" placeholder="Mot de passe" required/>
          </div>
          <input type="submit" value="Se connecter" class="btn solid" />
          <p class="social-text">Suivez-nous sur les reseaux sociaux</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
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
