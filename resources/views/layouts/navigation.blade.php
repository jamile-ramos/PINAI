<div class="wrapper" role="banner">
  <!-- Sidebar -->
  <div class="sidebar" id="menu" data-background-color="dark">
    <div class="sidebar-logo">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="dark">
        <a href="/dashboard " class="logo" aria-label="Ir para Página Inicial">
          <img src="/img/pinai-branca.svg" alt="Logotipo da Plataforma PINAI" class=" -brand" height="55" />
        </a>
        <div class="nav-toggle">
          <button class="btn btn-toggle toggle-sidebar" aria-label="Alternar barra lateral" aria-expanded="false" tabindex="0">
            <i class="gg-menu"></i>
          </button>
          <button class="btn btn-toggle sidenav-toggler" aria-label="Alternar barra lateral" aria-expanded="false" tabindex="0">
            <i class="gg-menu"></i>
          </button>
          <p class="px-2 text-menu">Menu</p>
        </div>
        <button class="topbar-toggler more">
          <i class="gg-more-vertical-alt"></i>
        </button>
      </div>
      <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner" role="navigation">
      <div class="sidebar-content">
        <ul class="nav nav-secondary">
          <li class="nav-item {{ request()->is('dashboard') ? 'active submenu' : '' }}">
            <a
              tabindex="0"
              href="/dashboard"
              class="collapsed"
              aria-expanded="false"
              aria-label="Ir para Página Inicial">
              <i class="fas fa-home {{ request()->is('dashboard') ? 'icon-active' : '' }}" aria-hidden="true"></i>
              <p>Página Inicial</p>
            </a>
          </li>
          @if(Auth::user()->tipoUsuario == 'admin')
          <li class="nav-item {{ request()->is('painelUsuarios*') ? 'active submenu' : '' }}">
            <a href="/painelUsuarios" tabindex="0" aria-label="Ir para a página de administração do Painel de Usuários">
              <i class="fas fa-users {{ request()->is('painelUsuarios*') ? 'icon-active' : '' }}" aria-hidden="true"></i>
              <p>Painel de usuários</p>
            </a>
          </li>
          @endif
          <li class="nav-item {{ request()->is('noticias*') ? 'active submenu' : '' }}">
            <a href="/noticias" data-btnNav="noticias" aria-label="Ir para o Portal de Notícias">
              <i class="fas fa-newspaper {{ request()->is('noticias*') ? 'icon-active' : '' }}" aria-hidden="true"></i>
              <p>Portal de Notícias</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('topicos*') || request()->is('postagens*') || request()->is('respostas*') ? 'active submenu' : '' }}">
            <a href="/topicos" data-btnNav="topicos" aria-label="Ir para o Fórum de Discussão">
              <i class="fas fa-comments {{ request()->is('topicos*') || request()->is('postagens*') || request()->is('respostas*') ? 'icon-active' : '' }}" aria-hidden="true"></i>
              <p>Fórum de Discussão</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('documentos*') ? 'active submenu' : '' }}">
            <a href="/documentos" data-btnNav="documentos" aria-label="Ir para a Biblioteca de Documentos">
              <i class="fas fa-pen-square {{ request()->is('documentos*') ? 'icon-active' : '' }}" aria-hidden="true"></i>
              <p>Biblioteca Digital</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('solucoes*') ? 'active submenu' : '' }}">
            <a href="/solucoes" data-btnNav="solucoes" aria-label="Ir para o Banco de Soluções">
              <i class="fas fa-table {{ request()->is('solucoes*') ? 'icon-active' : '' }}" aria-hidden="true"></i>
              <p>Banco de Soluções</p>
            </a>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#maps">
              <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
              <p>Mapa Interativo</p>
            </a>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#charts">
              <i class="far fa-chart-bar" aria-hidden="true"></i>
              <p>Projetos em andamento</p>
            </a>
          </li>
          <li class="nav-section">
            <span class="sidebar-mini-icon">
              <i class="fa fa-ellipsis-h"></i>
            </span>
            <h4 class="text-section">Outras páginas</h4>
          </li>
          <li class="nav-item {{ request()->is('myProfile*') || request()->is('profile*') ? 'active submenu' : ''}}">
            <a href="/myProfile" data-btnNav="profile" aria-label="Ir para Meu perfil">
              <i class="far fa-user {{ request()->is('myProfile') || request()->is('profile*') ? 'icon-active' : ''}}" aria-hidden="true"></i>
              <p>Perfil</p>
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
          <a href="index.html" class="logo" aria-label="Ir para página inicial">
            <img src="/img/pinai-branca.svg" alt="Logotipo da Plataforma PINAI" class="navbar-brand" height="40" />
          </a>
          <div class="nav-toggle" tabindex="0">
            <button class="btn btn-toggle toggle-sidebar" aria-label="Alternar barra lateral">
              <i class="gg-menu"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler" aria-label="Alternar barra lateral">
              <i class="gg-menu"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>

      <!-- Navbar Header -->
      <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom" role="navigation">>
        <div class="container-fluid">
          <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
          </nav>
          <ul class="navbar-nav topbar-nav align-items-start small">
            <li class="nav-item topbar-icon dropdown hidden-caret me-2 d-flex align-items-center">
              <a href="#main-content" class="skip-link text-white-50 fs-7 link-underline-opacity-0 link-underline-opacity-100-hover px-1">Ir para o conteúdo</a>
              <span class="badge text-bg-primary rounded-pill py-0 px-1" style="font-size: 0.65rem;">1</span>
            </li>
            <li class="nav-item topbar-icon dropdown hidden-caret me-2 d-flex align-items-center">
              <a href="#menu" class="skip-link text-white-50 fs-7 link-underline-opacity-0 link-underline-opacity-100-hover px-1">Ir para o menu</a>
              <span class="badge text-bg-primary rounded-pill py-0 px-1" style="font-size: 0.65rem;">2</span>
            </li>
            <li class="nav-item topbar-icon dropdown hidden-caret me-2 d-flex align-items-center">
              <a href="#rodape" class="skip-link text-white-50 fs-7 link-underline-opacity-0 link-underline-opacity-100-hover px-1">Ir para o rodapé</a>
              <span class="badge text-bg-primary rounded-pill py-0 px-1" style="font-size: 0.65rem;">3</span>
            </li>
          </ul>


          <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            <li class="nav-item topbar-icon dropdown hidden-caret">
              <a class="nav-link dropdown-toggle" href="#" id="constraste" role="button"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Contraste da página">
                <i class="fas fa-adjust"></i>
              </a>
            </li>
            <li class="nav-item topbar-icon dropdown hidden-caret">
              <a class="nav-link dropdown-toggle" href="#" id="aumentarFonte" role="button" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" aria-label="Aumentar fonte">
                <i class="fas fa-font"></i><sup><i class="fas fa-plus"></i></sup>
              </a>
            </li>
            <li class="nav-item topbar-icon dropdown hidden-caret">
              <a class="nav-link" data-bs-toggle="dropdown" href="#" id="diminuirFonte" aria-expanded="false" aria-label="Diminuir fonte">
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
                    <x-dropdown-link :href="route('profile.index')" class="custom-dropdown-link" id="link-profile">
                      {{ __('Meu perfil') }}
                    </x-dropdown-link>
                    <div class="dropdown-divider"></div>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                      @csrf

                      <x-dropdown-link :href="route('logout')"
                        class="custom-dropdown-link" id="logout-link"
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