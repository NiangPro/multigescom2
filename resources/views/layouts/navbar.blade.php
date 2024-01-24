<nav class="navbar sticky-top navbar-expand-lg main-navbar " style="position:fixed;background:#6777EF;">
    <form class="form-inline mr-auto">
      <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>

        <li><a href="{{route('message')}}" class="nav-link nav-link-lg"><i class="far fa-bell"></i><span class="badge">{{$notification}}</span></a>
        </li>
    </ul>

    </form>
    <ul class="navbar-nav navbar-right">

      <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="{{asset('storage/images/'.Auth()->user()->profil)}}" height="40" width="100" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">Bienvenu, {{Auth()->user()->prenom}}</div></a>
        <div class="dropdown-menu dropdown-menu-right">
          @if(Auth()->user()->isOpen())
          <a href="{{route('profil')}}" class="dropdown-item has-icon">
            <i class="far fa-user"></i> Profil
          </a>
          <a href="{{route('password')}}" class="dropdown-item has-icon">
            <i class="fa fa-lock" aria-hidden="true"></i> Mot de passe
          </a>
          <a href="{{route('general')}}" class="dropdown-item has-icon">
            <i class="fas fa-cog"></i> Parametres
          </a>
          @endif
          <div class="dropdown-divider"></div>
         <livewire:logout />
        </div>
      </li>
    </ul>
  </nav>
