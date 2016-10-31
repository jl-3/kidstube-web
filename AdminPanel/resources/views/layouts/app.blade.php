<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>KidsTube - @yield('title')</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">KidsTube</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            @if(Auth::check())
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/videos">Видео</a></li>
                    <li><a href="/categories">Категории</a></li>
                    <li><a href="/history">История просмотров</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/logout">Выход</a></li>
                </ul>
            @else
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/login">Вход</a></li>
                </ul>
            @endif
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    @yield('content')
</div>

<script src="js/app.js"></script>
</body>
</html>
