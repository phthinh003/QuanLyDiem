<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hệ Thống Quản Lý | @yield('title', $page_title ?? '')</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href=" {{ asset('images/logo.png') }}" />

    {{-- CSS all pages --}}
    @foreach(config('layout.resources.css') as $style)
        <link href="{{ asset($style) }}" rel="stylesheet" type="text/css"/>
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
    {{-- Loading... --}}
    @if (config('layout.page-loader.type') != '')
        @include('layouts.partials._page-loader')
    @endif

    @yield('content')

    {{-- Global Theme JS Bundle (used by all pages)  --}}
    @foreach(config('layout.resources.js') as $script)
        <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach

    <script>
        window.addEventListener('load', () => {
            const loading = document.querySelector('.loading-screen');
            loading.style.display = 'none'; // Hide the spinner when the page is fully loaded
        });
    </script>
    {{-- Includable JS --}}
    @yield('scripts')
</body>
</html>
