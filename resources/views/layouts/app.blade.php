<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="img/Favicon-azul.svg">

    <!-- CSS Files -->
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/plugins.min.css" />
    <link rel="stylesheet" href="/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="/css/mycss.css">

    <!-- Link dos icones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="/css/demo.css" />


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    @include('layouts.navigation')

    @yield('content')

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
    </div>

    <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="/js/core/jquery-3.7.1.min.js"></script>
    <script src="/js/core/popper.min.js"></script>
    <script src="/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="/js/setting-demo.js"></script>

    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });

        // Add Row
        $("#add-row").DataTable({
            pageLength: 10,
            lengthChange: false,
            searching: false,   
            language: {
                "paginate": {
                    "previous": "Anterior", // Alterar "Previous" para "Anterior"
                    "next": "Próximo" // Alterar "Next" para "Próximo"
                },
                "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas", // Alterar a frase para português
                "infoEmpty": "Mostrando 0 a 0 de 0 entradas", // Quando não houver dados
                "infoFiltered": "(filtrado de _MAX_ entradas)" // Quando houver filtro ativo
            }
        });

        var action =
            '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $("#addRowButton").click(function() {
            $("#add-row")
                .dataTable()
                .fnAddData([
                    $("#addName").val(),
                    $("#addPosition").val(),
                    $("#addOffice").val(),
                    action,
                ]);
            $("#addRowModal").modal("hide");
        });
    </script>
</body>

</html>