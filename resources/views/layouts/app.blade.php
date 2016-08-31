<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Toudoux</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700"> -->

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="css/app.css" rel="stylesheet">

    <!--<style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>-->
</head>
<body id="app-layout"class="@yield('bodyClass')">
    <nav class="navbar">
        <div class="navbar__container">
            <a class="navbar__header" href="{{ url('/home') }}" title="Home">
                <img class="navbar__header__logo" src="./img/logo.svg" alt="Toudoux" />
                <h1 class="navbar__header__text">Toudoux</h1>
            </a>
            <ul class="navbar__items">
                <li class="navbar__item"><a class="navbar__link" href="{{ url('/') }}">Home</a></li>
                @if (Auth::guest())
                    <li class="navbar__item"><a class="navbar__link" href="{{ url('/login') }}">Login</a></li>
                    <li class="navbar__item"><a class="navbar__link" href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="navbar__item"><a class="navbar__link" href="{{ url('/tasks') }}">My tasks</a></li>
                    <li class="navbar__item"><a class="navbar__link" href="{{ url('/logout') }}">Logout</a></li>
                    <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li> -->
                @endif
            </ul>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="js/main.js"></script>

    </script>
</body>
</html>
