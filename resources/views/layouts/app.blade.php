<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trang Tải ảnh</title>
    <link rel="shortcut icon" type="image/png" href="/public/images/logo.ico"/>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .post-body-image {
            width: 100%;
        }

        .footer-item {
        }

        .post {
            margin-bottom: 10px;
        }

        .card{
            margin-left: -205px;
            margin-right: 110px;
        }

        .card-body {
            padding: 0 !important;
        }

        .time {
            color: #606770;
        }

        .comment-block {
            background: #f2f3f5;
            padding: 8px 10px;
            border-radius: 18px;
        }

        .reply-block {
            margin-left: 30px;

        }

        .reply-item {
            margin: 4px;
            background: #f2f3f5;
            padding: 5px;
            border-radius: 20px;
        }

        .input {
            border-radius: 30px;
        }

        .form-control {
            border-radius: 18px;
            margin-top: 0px;
            margin-bottom: 5px;
        }

        .time-block {
            font-size: 10px;
            margin-top: 0px;
            display: block;
        }

        .like-block {
            padding-top: 0px;
        }

        .post-footer {
            display: inline;
        }

        .footer-item {
            display: inline-table;
        }

        .comment-footer {
            display: inline;
        }

        .footer-block {
            display: inline-block;
            padding-right: 5px;
        }

        .react-block {
            padding-top: 5px;
        }

        .upvote-block {
            padding-left: 10px;
        }

        .reply-block {
            padding-bottom: 5px;
        }

        .reply-control {
            margin-top: 10px;
        }

        .time-color {
            color: #606770;
        }

        .comment-time {
            margin-top: -5px;
        }

        .reply-react {
            margin-top: -20px;
            margin-left: 60px;
        }

        #reply-position {
            margin-left: -38px;
        }

        #font {
            font-size: 11px;
        }

        .row {
            margin-top: 40px;
            display: block;
        }
    </style>
</head>
<body>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v4.0"></script>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Haivl
            </a>
            <a href="{{ url('/dashboard') }}" class="navbar-brand">
                Upload Image
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/webpage"
                                   onclick="event.preventDefault();
                                                     document.getElementById('detail-form').submit();">
                                    User
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>


                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>

                                <form id="detail-form" action="/webpage" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
