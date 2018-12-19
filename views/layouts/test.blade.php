<!DOCTYPE html/>
<html>
<head>
    <title>The lag | @yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<div class="container">
    <div id="main-menu" role="nav">
        <a href="/"><img src="../../public/img/logo.png" alt="The Lag"/></a>
        <ul>
            <a href="#"><li>COURS</li></a>
            <a href="/coach"><li>COACHS</li></a>
            <a href="/index"><li>JEUX</li></a>
            <a href="#"><li>CONTACT</li></a>
        </ul>
    </div>
    @yield('content')
</div>
@yield('javascript')
</body>
</html>