<div class="main-sidebar" style="position: fixed;">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{route("home")}}">
            <figure >
                <img style="width: 50px!important; height: 48px!important;" class=" avatar mr-2" src="{{asset('storage/images/'.Auth()->user()->entreprise->profil)}}" alt="logo">{{Auth()->user()->entreprise->nom}}
               
              </figure>
            </a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{route("home")}}">
            @if (Auth()->user()->entreprise_id !== null)
                {{Auth()->user()->entreprise->sigle}}
            @else
                GC
            @endif
        </a>
      </div>
      <ul class="sidebar-menu">


          <li class="@if ($page == "home") active @endif"><a class="nav-link" href="{{route('home')}}"><i class="fas fa-fire"></i> <span>Tableau de bord</span></a></li>
          @if (Auth()->user()->role === 'Super Admin')
          
          <li class="menu-header">Super Admin</li>
          <li class="@if ($page == "entreprise") active @endif"><a class="nav-link" href="{{route('entreprises')}}"><i class="fas fa-th-large"></i> <span>Entreprises</span></a></li>
          <li class="@if ($page == "users") active @endif"><a class="nav-link" href="{{route('users')}}"><i class="fas fa-users-cog"></i> <span>Utilisateurs</span></a></li>
          @endif
          @if(Auth()->user()->isOpen())

          @if (Auth()->user()->isAdmin())
          <li class="menu-header">Admin</li>
          <li class="@if ($page == "staticData") active @endif"><a class="nav-link" href="{{route('staticData')}}"><i class="fa fa-database" aria-hidden="true"></i> <span>Données Statiques</span></a></li>
          <li class="@if ($page == "employe") active @endif"><a class="nav-link" href="{{route('employe')}}"><i class="fas fa-user-friends"></i> <span>Employés</span></a></li>
          <li class="nav-item dropdown @if ($page == "comptable" || $page == "commercial"  || $page == "general") active @endif">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-users-cog" aria-hidden="true"></i> <span>Autres Utilisateurs</span></a>
            <ul class="dropdown-menu">
                <li  class="@if ($page == "admin") active @endif"><a href="{{route('admin')}}"><i class="fa fa-user-secret" aria-hidden="true"></i> Administrateurs</a></li>
                <li  class="@if ($page == "commercial") active @endif"><a href="{{route('commercial')}}"><i class="fa fa-user-circle" aria-hidden="true"></i> Commerciaux</a></li>
                <li class="@if ($page == "comptable") active @endif"><a href="{{route('comptable')}}"><i class="fa fa-user-secret" aria-hidden="true"></i>Comptables</a></li>
            </ul>
          </li>
          @endif
          @if (Auth()->user()->isAdmin() || Auth()->user()->isCommercial())
          <li class="menu-header">Commercial</li>
          <li class="@if ($page == "produit") active @endif"><a class="nav-link" href="{{route('produit')}}"><i class="fab fa-product-hunt" aria-hidden="true"></i> <span>Produits</span></a></li>
          <li class="@if ($page == "client") active @endif"><a class="nav-link" href="{{route('client')}}"><i class="fa fa-users" aria-hidden="true"></i> <span>Clients</span></a></li>
          <li class="@if ($page == "fournisseur") active @endif"><a class="nav-link" href="{{route('fournisseur')}}"><i class="fas fa-street-view" aria-hidden="true"></i> <span>Fournisseurs</span></a></li>
          <li class="@if ($page == "prospect") active @endif"><a class="nav-link" href="{{route('prospect')}}"><i class="fa fa-tty" aria-hidden="true"></i> <span>Prospects</span></a></li>

          @endif
          @if (Auth()->user()->isAdmin() || Auth()->user()->isComptable())
          <li class="menu-header">Comptable</li>

          <li class="@if ($page == "depense") active @endif"><a class="nav-link" href="{{route('depense')}}"><i class="fas fa-balance-scale   "></i> <span>Dépenses</span></a></li>
          <li class="@if ($page == "devis") active @endif"><a class="nav-link" href="{{route('devis')}}"><i class="fas fa-file-invoice   "></i> <span>Devis</span></a></li>
          <li class="@if ($page == "vente") active @endif"><a class="nav-link" href="{{route('vente')}}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Ventes</span></a></li>
          <li class="@if ($page == "rapport") active @endif"><a class="nav-link" href="{{route('rapport')}}"><i class="fas fa-chart-bar" aria-hidden="true"></i> <span>Rapports</span></a></li>
          @endif
          @if (!Auth()->user()->isSuperAdmin())
          <li class="@if ($page == "reunion") active @endif"><a class="nav-link" href="{{route('reunion')}}"><i class="fa fa-handshake" aria-hidden="true"></i> <span>Réunions</span></a></li>
            <li class="@if ($page == "tache") active @endif"><a class="nav-link" href="{{route('tache')}}"><i class="fas fa-edit" aria-hidden="true"></i> <span>Tâches</span></a></li>
            @endif
            @endif
            <li class="@if ($page == "history") active @endif"><a class="nav-link" href="{{route('history')}}"><i class="fa fa-history" aria-hidden="true"></i> <span>Historiques</span></a></li>
            <li class="@if ($page == "message") active @endif"><a class="nav-link" href="{{route('message')}}"><i class="fa fa-envelope-open" aria-hidden="true"></i> <span>Messages</span></a></li>
            @if (Auth()->user()->isSuperAdmin())
            <li class="@if ($page == "abonnement") active @endif"><a class="nav-link" href="{{route('abonnement')}}"><i class="fa fa-money-bill" aria-hidden="true"></i> <span>Abonnements</span></a></li>
          @endif
          @if(Auth()->user()->isOpen())
          <li class="menu-header">Configurations </li>
          <li class="nav-item dropdown @if ($page == "profil" || $page == "password"  || $page == "general") active @endif">
            <a href="#" class="nav-link has-dropdown"><i class="fa fa-cogs" aria-hidden="true"></i> <span>Parametres </span></a>
            <ul class="dropdown-menu">
                <li  class="@if ($page == "profil") active @endif"><a href="{{route('profil')}}"><i class="fa fa-user-circle" aria-hidden="true"></i> Profil</a></li>
                <li class="@if ($page == "password") active @endif"><a href="{{route('password')}}"><i class="fa fa-lock" aria-hidden="true"></i>Mot de passe</a></li>
                @if (Auth()->user()->isAdmin() || Auth()->user()->isSuperAdmin())
                <li class="@if ($page == "general") active @endif"><a href="{{route('general')}}"><i class="fa fa-wrench" aria-hidden="true"></i> General</a></li>
                @endif
            </ul>
          </li>
          @endif
        </ul>

    </aside>
  </div>
