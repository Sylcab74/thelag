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
            <div id="user-navbar">
                <?php if (Lag\Core\Auth::isLogged()): ?>
                    <div role="img" id="circle"></div>
                    <img id="caret" src="../../public/img/caret.png" alt="Profil"/>
                <?php  else: ?>
                    <div class="login_register">
                        <p><a href="/user/login">Connexion</a></p>
                        <p><a href="/user/register">Inscription</a></p>
                    </div>
                <?php  endif; ?>
            </div>
            <div id="hidden-menu">
                <ul>
                    <li><a href="/user/profil">Mon profil</a></li>
                    <li><a href="/user/logout">Se déconnecter</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>

<script>
    var flag = false;
    var menu = document.getElementById("hidden-menu");

    document.getElementById("user-navbar").addEventListener("click",function(){
        console.log('cc');
        if (!flag){
            menu.getElementsByTagName("li")[0].setAttribute("style","display:block");
            menu.getElementsByTagName("li")[1].setAttribute("style","display:block");
            document.getElementById("hidden-menu").style.visibility='visible';
            document.getElementById("hidden-menu").style.transition="0.25s";
            document.getElementById("hidden-menu").style.height = "auto";
            flag = true;
        } else {
            menu.getElementsByTagName("li")[0].setAttribute("style","display:none");
            menu.getElementsByTagName("li")[1].setAttribute("style","display:none");
            document.getElementById("hidden-menu").style.visibility='hidden';
            document.getElementById("hidden-menu").style.height = "0";
            flag = false;
        }

    });
</script>
@yield('javascript')
</body>
</html>