<!DOCTYPE html>
<html lang="FR-fr">
<head>
    <title>The lag | @yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

    <header>
        <nav id="main-menu">
            <a href="/"><img src="../../public/img/logo.png" alt="The Lag"/></a>
            <ul class="nav_list">
                <li><a href="/coach">COACHS</a></li>
                <li><a href="/game">JEUX</a></li>
                <li><a href="#">CONTACT</a></li>
            </ul>
            @if(Lag\Core\Auth::isLogged())
                <div class="user-navbar" id="user">
                    <div role="img" id="circle"></div>
                    <img id="caret" src="../../public/img/caret.png" alt="Profil"/>
                </div>
                <div id="hidden-menu">
                    <ul>
                        <li><a href="/user/profil">Mon profil</a></li>
                        <li><a href="/user/logout">Se déconnecter</a></li>
                    </ul>
                </div>
            @else
                <div class="user-navbar">
                    <div class="login_register">
                        <p><a href="/user/login">Connexion</a></p>
                        <p><a href="/user/register">Inscription</a></p>
                    </div>
                </div>
            @endif
        </nav>
    </header>
    <main>
        @yield('content')
    </main>

<script>
    var flag = false;
    const menu = document.getElementById("hidden-menu");

    document.getElementById("user").addEventListener("click",function(){
        if (!flag){
            menu.style.visibility='visible';
            menu.style.transition="0.25s";
            menu.style.height = "auto";
            flag = true;
        } else {
            menu.style.visibility='hidden';
            menu.style.height = "0";
            flag = false;
        }

    });
</script>
@yield('javascript')
</body>
</html>