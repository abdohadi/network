<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Abdelrahman">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? config('app.name')." | ".$title : config('app.name') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/jquery.modal.min.css') }}" />
    <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @if (app()->getLocale() == 'ar')
        <style>
            body {
            }
        </style>
    @endif

</head>
<body class="bg-main">
    <div id="app">
        @auth
            @include('layouts._nav')
        @endauth

        <main class="py-1 px-10">
            <div id="main" style="margin-top:51px">
                @yield('content')
            </div>
        </main>

        @yield('footer')
    </div>

    {{-- Modals --}}
    @include('posts._edit_post_modal')
    @include('posts._share_post_modal')
    @include('posts._edit_comment_modal')
    


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.modal.min.js') }}"></script>

</body>
</html>
