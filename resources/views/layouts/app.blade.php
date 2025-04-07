<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/favicon-azul.svg') }}">

    <!-- CSS do Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />

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

<body class="tema-escuro">

    @include('layouts.navigation')

    <div class="col-md-12 container-all">
        @yield('content')
    </div>

    <footer class="footer">
        <div class="container-fluid d-flex justify-content-between">
            <nav class="pull-left">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/noticias">
                            Notícias
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"> Fórum </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"> Banco de Soluções </a>
                    </li>
                </ul>
            </nav>
            <div class="copyright">
                &copy 2024, PINAI | Todos os direitos reservados.
            </div>
            <div>
                Criado por Jamile Ramos
            </div>
        </div>
    </footer>

    <!-- Carregar o jQuery (primeiro para dependências de outros scripts) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Carregar o Bootstrap (JS com dependências incluídas) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Carregar os scripts locais principais (garanta que estes são necessários) -->
    <!-- Se você já está usando o Bootstrap.bundle.min.js, pode não precisar do bootstrap.min.js local -->
    <script src="/js/core/popper.min.js"></script> <!-- Se necessário -->
    <script src="/js/core/bootstrap.min.js"></script> <!-- Se necessário -->

    <!-- Carregar o JS personalizado -->
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