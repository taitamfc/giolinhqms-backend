<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><!-- End Required meta tags -->
    <!-- Begin SEO tag -->
    <title> Đăng Nhập Hệ Thống </title>
    
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('asset/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('asset/favicon.ico') }}">
    <meta name="theme-color" content="#3063A0"><!-- End FAVICONS -->
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600" rel="stylesheet"><!-- End GOOGLE FONT -->
    <!-- BEGIN PLUGINS STYLES -->
    <link rel="stylesheet"
        href="//cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- END PLUGINS STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link rel="stylesheet" href="{{ asset('asset/stylesheets/theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/stylesheets/theme-dark.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/stylesheets/custom.css') }}">
    <!-- END THEME STYLES -->
</head>

<body>
    <!--[if lt IE 10]>
    <div class="page-message" role="alert">You are using an <strong>outdated</strong> browser. Please <a class="alert-link" href="http://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</div>
    <![endif]-->
    <!-- .auth -->
    <main class="auth">
        <header id="auth-header" class="auth-header"
            style="background-image: url(assets/images/illustration/img-1.png);">
            <h1>
                QUẢN LÝ THIẾT BỊ 
                <span class="sr-only">Sign In</span>
            </h1>
            
        </header><!-- form -->

        @yield('content')
        <!-- /.auth-form -->
        <!-- copyright -->
        <footer class="auth-footer"> © 2023 School. 
        </footer>
    </main><!-- /.auth -->
    <!-- BEGIN BASE JS -->
    <script src="{{ asset('asset/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/vendor/popper.js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('asset/vendor/bootstrap/js/bootstrap.min.js') }}"></script> <!-- END BASE JS -->
    <!-- BEGIN PLUGINS JS -->
    <script src="{{ asset('asset/vendor/particles.js/particles.js') }}"></script>
    <script>
        /**
         * Keep in mind that your scripts may not always be executed after the theme is completely ready,
         * you might need to observe the `theme:load` event to make sure your scripts are executed after the theme is ready.
         */
        $(document).on('theme:init', () => {
            /* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
            particlesJS.load('auth-header', 'assets/javascript/pages/particles.json');
        })
    </script> <!-- END PLUGINS JS -->
    <!-- BEGIN THEME JS -->
    <script src="{{ asset('asset/javascript/theme.js') }}"></script> <!-- END THEME JS -->

</body>

</html>
