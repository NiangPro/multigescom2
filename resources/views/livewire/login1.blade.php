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
          <div>
            <strong> Mot de passe oublié </strong> <a href="{{route('passwordforget')}}" style="text-decoration: none;">Cliquez ici</a>
          </div>
          <span class="d-flex justify-content-center">
            <input type="submit" value="Se connecter" class="btn solid" />
            <a href="{{route('inscription')}}" style="text-decoration: none;">S'inscrire</a>
          </span>
          <p class="social-text">Suivez-nous sur les reseaux sociaux</p>
          <div class="social-media">
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

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h1>{{ucfirst($param->entreprise->nom)}}</h1>
          
          <img src="{{asset('storage/images/login.png')}}" class="image" alt="" />
        </div>
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
