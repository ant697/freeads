<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/fontAwesome5-3-1.css" rel="stylesheet">
    <link href="/sass/custom.css" rel="stylesheet">
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<?php use App\Http\Middleware\CheckMessages; ?>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">

                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/posts') }}">
                        {{ config('app.name', 'Free Ads') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if (CheckMessages::$newMessages)
                        <?php $numberMessages = CheckMessages::$numberMessages ?>
                                <li>
                                    <a href="{{ url('/users/' . Auth::user()->id . '/messages') }}"
                                       onclick=""><i class="fas fa-envelope"></i> Vous avez {{ $numberMessages }}
                                    {{ ($numberMessages > 1) ? 'nouveaux messages' : 'nouveau message' }}
                                    </a>
                                </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="fab fa-buysellads"></i>
                                    Posts <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/posts') }}">
                                            <i class="fas fa-credit-card"></i>
                                            Tous les Posts</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/posts' . '?user=' . Auth::id()) }}">
                                            <i class="far fa-money-bill-alt"></i>
                                            Mes Posts</a>
                                    </li>

                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="far fa-user"></i>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/users/' . Auth::user()->id) }}"
                                           onclick="">
                                            <i class="far fa-user"></i>
                                            User
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/users/' . Auth::user()->id . '/messages') }}"
                                           onclick="">
                                            <i class="fas fa-envelope"></i>
                                            Messages
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('/users/' . Auth::user()->id) . '/edit' }}"
                                           onclick="">
                                            <i class="far fa-edit"></i>
                                            Editer son compte
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/users/' . Auth::user()->id) . '/delete' }}"
                                           onclick="">
                                            <i class="far fa-trash-alt"></i>
                                            Supprimer son compte
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i>
                                            Se deconnecter
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>

                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>
