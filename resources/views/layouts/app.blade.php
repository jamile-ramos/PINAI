<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/favicon-azul.svg') }}">

    <!-- CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- CSS de bibliotecas externas -->
    <link rel="stylesheet" href="/css/plugins.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="/css/mycss.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="tema-escuro @if(Auth::user()->tipoUsuario == 'comum') is-comum @else is-admin @endif">

    @include('layouts.navigation')

    <div class="container-all" role="main" id="main-content" tabindex="-1">
        @yield('content')
    </div>
    @yield('footer')
    <footer class="footer" role="contentinfo" id="rodape">
        <div class="container-fluid d-flex justify-content-between flex-column">
            <nav class="pull-left" aria-label="Links do rodapé">
                <ul class="nav justify-content-center">
                    <li class="nav-item item-footer">
                        <a class="nav-link" href="/noticias">Portal de Notícias</a>
                    </li>
                    <li class="nav-item item-footer">
                        <a class="nav-link" href="/topicos">Fórum de Discussão</a>
                    </li>
                    <li class="nav-item item-footer">
                        <a class="nav-link" href="/documentos">Biblioteca Digital</a>
                    </li>
                    <li class="nav-item item-footer">
                        <a class="nav-link" href="/solucoes">Banco de Soluções</a>
                    </li>
                    <li class="nav-item item-footer">
                        <a class="nav-link" href="/acessibilidade"> Acessibilidade </a>
                    </li>
                    <li class="nav-item item-footer">
                        <a class="nav-link" href="/sobre"> Sobre </a>
                    </li>
                </ul>
            </nav>
            <div class="copyright my-3 text-center">
                &copy 2025, PINAI | Todos os direitos reservados.
            </div>
            <div>
                Criado por Jamile Ramos
            </div>
        </div>
    </footer>

    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <!-- Carregar o jQuery (primeiro para dependências de outros scripts) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Carregar o Bootstrap (JS com dependências incluídas) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Carregar o script do VLibras (deve ser carregado antes de outros scripts personalizados) -->
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>

    <!-- Carregar os scripts locais principais -->
    <script src="{{ asset('js/myjs.js') }}"></script>


    <!-- Carregar plugins adicionais -->
    <script src="/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="/js/plugin/chart.js/chart.min.js"></script>
    <script src="/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script src="/js/plugin/chart-circle/circles.min.js"></script>
    <script src="/js/plugin/datatables/datatables.min.js"></script>
    <script src="/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="/js/plugin/jsvectormap/world.js"></script>
    <script src="/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="/js/kaiadmin.min.js"></script>

    <!-- Métodos de demonstração do Kaiadmin, não inclua no seu projeto -->
    <script src="/js/setting-demo.js"></script>
    

</body>

</html>