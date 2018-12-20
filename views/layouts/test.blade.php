<!DOCTYPE html/>
<html>
<head>
    <title>The lag | @yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<header>
    <div id="main-menu" role="nav">
        <a href="/"><img src="../../public/img/logo.png" alt="The Lag"/></a>
        <ul>
            <a href="#"><li>COURS</li></a>
            <a href="/coachs"><li>COACHS</li></a>
            <a href="/games"><li>JEUX</li></a>
            <a href="#"><li>CONTACT</li></a>
        </ul>
    </div>
</header>
<main>

    @yield('content')
<main>
@yield('javascript')
</body>
</html>