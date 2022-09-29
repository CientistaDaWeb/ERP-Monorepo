<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Acquasana - @yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">

    <!-- Themify icons -->
    <link rel="stylesheet" type="text/css" href="/css/themify-icons.css">

    <!-- Font-Awesome -->
    <link rel="stylesheet" type="text/css" href="/css/fontawesome-all.css">

    <!-- Icomoon -->
    <link rel="stylesheet" type="text/css" href="/css/icomoon.css">

    <!-- Plugins -->
    <link rel="stylesheet" type="text/css" href="/css/plugins.css">

    <!-- Animate.css -->
    <link rel="stylesheet" href="/css/animate.css">

    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="/css/owl.carousel.css">

    <!-- Swiper Slider Styles -->
    <link rel="stylesheet" href="/css/slider.css">

    <!-- Navbar Styles -->
    <link rel="stylesheet" type="text/css" href="/css/navigation-acquasana.css" id="navigation_menu">

    <!-- Main Styles -->
    <link rel="stylesheet" type="text/css" href="/css/default.css">
    <link rel="stylesheet" type="text/css" href="/css/styles-acquasana.css" id="main_styles">

    <!-- Fonts Google -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900"
          rel="stylesheet">


</head>
<body>


<!-- Preloader Start-->
<div id="preloader">
    <div class="row loader">
        <div class="loader-icon"></div>
    </div>
</div>
<!-- Preloader End -->


<!-- Top-Bar START -->
<div id="top-bar" class="hidden-md-down">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-12">
                <ul class="top-bar-info">
                    <li><i class="fas fa-map-marker-alt"></i> R. Três de Outubro, 40</li>
                    <li><i class="fas fa-phone-square"></i> Fone: (54) 3055-3686</li>
                    <li><i class="fa fa-envelope"></i>E-mail: acquasana@acquasana.com.br</li>
                </ul>
            </div>
            <div class="col-md-3 col-12">
                <ul class="social-icons hidden-sm">
                    <li><a href="tel:+555430553686"><i class="fab fa-skype"></i></a></li>
                    <li><a href="https://www.facebook.com/acquasanaefluentes" target="_blank"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="/contato"><i class="fa fa-envelope"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Top-Bar END -->


<!-- Navbar START -->
<header>
    <nav id="navigation4" class="container navigation">
        <div class="nav-header">
            <a class="nav-brand" href="/">
                <img src="/img/logos/logo.png" class="img-fluid" alt="logo" id="main_logo">
            </a>
            <div class="nav-toggle"></div>
        </div>
        <div class="nav-menus-wrapper">
            <ul class="nav-menu align-to-right">
                <li><a href="/sobre-nos">Institucional</a></li>
                <li><a href="/servicos">Serviços</a>
                    <ul class="nav-dropdown">
                        <li><a href="/servicos/residencia">Residência</a></li>
                        <li><a href="/servicos/condominio">Condomínio</a></li>
                    </ul>
                </li>
                <li><a href="/vantagens">Vantagens</a></li>
                <li><a href="/informacoes/estacao-tratamento">Informações</a>
                    <ul class="nav-dropdown">
                        <li><a href="/informacoes/estacao-tratamento">Estação de Tratamento</a></li>
                        <li><a href="/informacoes/legislacao">Legislação</a></li>
                        <li><a href="/informacoes/perguntas-frequentes">Perguntas Frequentes</a></li>
                    </ul>
                </li>
                <li><a href="/contato">Contato</a></li>
                <li><a href="/area-restrita">Área Restrita</a></li>
            </ul>
        </div>
    </nav>
</header>
<!-- Navbar END -->

@yield('content')

<!-- Footer START -->
<footer class="footer-style-1">
    <div class="container">
        <div class="row">
            <!-- Column 1 Start -->
            <div class="col-md-3 col-sm-6 col-12 align-self-center text-sm-left text-center">
                <a href="/"><img src="/img/logos/logo-footer.png" class="img-fluid logo-footer" alt="img"></a>
                <div class="mt-40"></div>
                <ul class="footer-style-1-social-links text-center">
                    <li><a href="tel:+555430553686"><i class="fab fa-skype"></i></a></li>
                    <li><a href="https://www.facebook.com/acquasanaefluentes" target="_blank"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="/contato"><i class="fa fa-envelope"></i></a></li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-6 col-4">
                <h3>Menu</h3>
                <ul class="footer-style-1-links">
                    <li><a href="/sobre-nos">Institucional</a></li>
                    <li><a href="/vantagens">Vantagens</a></li>
                    <li><a href="/contato">Contato</a></li>
                    <li><a href="/clintes">Área Restrita</a></li>
                </ul>
            </div>
            <!-- Column 2 End -->

            <!-- Column 3 Start -->
            <div class="col-md-2 col-sm-6 col-4">
                <h3>Serviços</h3>
                <ul class="footer-style-1-links">
                    <li><a href="/servicos/residencia">Residência</a></li>
                    <li><a href="/servicos/condominio">Condomínio</a></li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-6 col-4">
                <h3>Informações</h3>
                <ul class="footer-style-1-links">
                    <li><a href="/informacoes/estacao-tratamento">Estação de Tratamento</a></li>
                    <li><a href="/informacoes/legislacao">Legislação</a></li>
                    <li><a href="/informacoes/perguntas-frequentes">Perguntas Frequentes</a></li>
                </ul>
            </div>
            <!-- Column 3 End -->

            <!-- Column 4 Start -->
            <div class="col-md-3 col-sm-6 col-12">
                <h3>Contato</h3>
                <ul class="footer-style-1-contact-info">
                    <li><i class="fas fa-map-marker-alt"></i> <span>R. Três de Outubro, 40</span></li>
                    <li><i class="fas fa-phone-square"></i> <span>Fone: (54) 3055-3686</span></li>
                    <li><i class="fa fa-envelope"></i> <span> acquasana@acquasana.com.br</span></li>
                </ul>
            </div>
            <!-- Column 4 End -->
        </div>
    </div>
</footer>
<!-- Footer END -->


<!-- Scroll to top button Start -->
<a href="#" class="scroll-to-top"><i class="fas fa-chevron-up"></i></a>
<!-- Scroll to top button End -->

<!-- Jquery -->
<script src="/js/jquery.min.js"></script>

<!-- Plugins JS-->
<script src="/js/plugins.js"></script>

<!-- Navbar JS -->
<script src="/js/navigation.js"></script>
<script src="/js/navigation.fixed.js"></script>

<!-- GoogleMaps -->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDOq0I_ojSB7fWPlOiaPidErlXpoqxD2p0"></script>

<!-- Main JS -->
<script src="/js/main.js"></script>


</body>
</html>
