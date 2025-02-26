<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hệ thống Quản Lý | @yield('title', $page_title ?? '')</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href=" {{ asset('images/logo.png') }}" />

    {{-- Boxicon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    {{-- CSS all pages --}}
    @foreach (config('layout.resources.css') as $style)
        <link href="{{ asset($style) }}" rel="stylesheet" type="text/css" />
    @endforeach

    {{-- Includable CSS --}}
    @yield('styles')

    <style>
        .page-loader {
            display: block;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>
    <div class="row m-0">
        {{-- <div class="col-3">
            @include('layouts.admin.header')
        </div> --}}
        @include('layouts.menu.menu1')
        <div class="col">
            @yield('content')
            @include('layouts.admin.footer')
        </div>
    </div>

    {{-- Loading... --}}
    @if (config('layout.page-loader.type') != '')
        @include('layouts.partials._page-loader')
    @endif

    {{-- Global Theme JS Bundle (used by all pages)  --}}
    @foreach (config('layout.resources.js') as $script)
        <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach

    <script>
        window.addEventListener('load', () => {
            const loading = document.querySelector('.loading-screen');
            loading.style.display = 'none'; // Hide the spinner when the page is fully loaded
        });
    </script>
    @include('sweetalert::alert')

    {{-- Includable JS --}}
    @yield('scripts')
</body>

</html>
