<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('img/logo-apostador.png')}}" rel="shortcut icon">
    <title>Apostador Online</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Sweetalert -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert2.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @yield("css")
</head>
<body>
    <div class="main-page">
        @yield('content')
    </div>

    <footer class="mt-4">
        <div class="container">
            &copy; 2022 @if(date("Y") != 2022) ~ {{date("Y")}} @endif Desenvolvido por WeXark
        </div>
    </footer>

     <!-- jQuery -->
     <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
     <!-- Bootstrap 4 -->
     <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
     <!-- Axios -->
     <script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
     <!-- Sweetalert -->
     <script src="{{ asset('plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    @yield("scripts")
</body>
</html>