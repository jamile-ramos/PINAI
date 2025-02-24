  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
      <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="/dashboard " class="logo">
            <img src="/img/pinai-branca.svg" alt="navbar brand" class=" -brand" height="55" />
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          <ul class="nav nav-secondary">
            <li class="nav-item">
              <a
                href="/dashboard"
                class="collapsed"
                aria-expanded="false">
                <i class="fas fa-home"></i>
                <p>Dashboard</p>
              </a>
            </li>
            @if(Auth::user()->tipoUsuario == 1)
            <li class="nav-item">
              <a href="/painelUsuarios">
                <i class="fas fa-users"></i>
                <p>Painel de usuários</p>
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a href="/noticias" data-btnNav = "noticias">
                <i class="fas fa-newspaper"></i>
                <p>Portal de Notícias</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/topicos" data-btnNav = "topicos">
                <i class="fas fa-comments"></i>
                <p>Fórum de discussão</p>
              </a>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#forms">
                <i class="fas fa-pen-square"></i>
                <p>Biblioteca Digital</p>
              </a>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#tables">
                <i class="fas fa-table"></i>
                <p>Banco de Soluções</p>
              </a>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#maps">
                <i class="fas fa-map-marker-alt"></i>
                <p>Mapa Interativo</p>
              </a>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#charts">
                <i class="far fa-chart-bar"></i>
                <p>Projetos em andamento</p>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
              <img src="/img/pinai-branca.svg" alt="navbar brand" class="navbar-brand" height="40" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <!-- Navbar Header -->
        <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
          <div class="container-fluid">
            <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
            </nav>

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
              <li class="nav-item topbar-icon dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button"
                  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-adjust"></i>
                </a>
              </li>
              <li class="nav-item topbar-icon dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-font"></i><sup><i class="fas fa-plus"></i></sup>
                </a>
              </li>
              <li class="nav-item topbar-icon dropdown hidden-caret">
                <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                  <i class="fas fa-font"></i><sup><i class="fas fa-minus"></i></sup>
                </a>
              </li>

              <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                  <div class="avatar-sm">
                    <div class="user-icon-circle">
                      <i class="fa fa-user"></i>
                    </div>
                  </div>
                  <span class="profile-username">
                    <span class="fw-bold">{{ Auth::user()->name }}</span>
                  </span>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                  <div class="dropdown-user-scroll scrollbar-outer">
                    <li>
                      <div class="user-box">

                        <div class="u-text">
                          <h4>{{ Auth::user()->name }}</h4>
                          <p class="text-muted">{{ Auth::user()->email }}</p>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                      <x-dropdown-link :href="route('profile.edit')" class="custom-dropdown-link">
                        {{ __('Meu perfil') }}
                      </x-dropdown-link>
                      <div class="dropdown-divider"></div>
                      <!-- Authentication -->
                      <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                          class="custom-dropdown-link"
                          onclick="event.preventDefault();
                                                this.closest('form').submit();">
                          {{ __('Sair') }}
                        </x-dropdown-link>
                      </form>
                    </li>
                  </div>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>