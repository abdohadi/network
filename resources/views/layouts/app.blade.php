<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @if (app()->getLocale() == 'ar')
        <link href="https://fonts.googleapis.com/css?family=Cairo:600,600&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: Cairo;
            }
        </style>
    @endif

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body class="bg-main">
    <div id="app">
        @include('layouts._nav')

        <main class="py-1 px-10">
            <div id="main" style="margin-top:51px">
                @yield('content')
            </div>
        </main>

        @yield('footer')
    </div>

    {{-- Modals --}}
    @include('posts._edit_post_modal')
    @include('posts._edit_comment_modal')
    


    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
