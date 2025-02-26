<!doctype html>
<html lang="en">

<head>
    <title>Hệ Thống Quản Lý | @yield('title', $page_title ?? '')</title>
    {{-- Favicon --}}
    <link rel="shortcut icon" href=" {{ asset('images/logo.png') }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="{{ asset('css/canbocss/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/canbocss/customcard.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/canbocss/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/crud/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('css/crud/datatables/datatables.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link rel="stylesheet" href="{{ asset('css/canbocss/custom.css') }}">
    @yield('styles')
</head>

<body>

    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
            <div class="p-4 pt-1">
                <h1><a href="index.html" class="logo">THPT <br/> TÂY ĐÔ</a></h1>
                @include('layouts.menu.menucanbo')

            </div>
        </nav>

        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">

            @yield('content')

        </div>
    </div>



    <script src="{{ asset('js/canbojs/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/canbojs/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/canbojs/popper.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/canbojs/bootstrap.min.js') }}" type="text/javascript"></script>

    {{-- <script src="{{ asset('js/crud/datatables/datatables.min.js') }}" type="text/javascript"></script> --}}
    <script src="{{ asset('js/crud/datatables/datatables.js') }}" type="text/javascript"></script>
    @yield('scripts')

</body>

</html>
