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
            <a href="/coach"><li>COACHS</li></a>
            <a href="/game"><li>JEUX</li></a>
            <a href="#"><li>CONTACT</li></a>
        </ul>
    </div>
    <div role="nav" id="user-navbar">
        <div role="img" id="circle"></div>
        <img id="caret" src="../../public/img/caret.png"/>
    </div>
    <div role="nav" id="hidden-menu">
        <ul>
        <li><a href="#">Mon profil</a></li>
        <li><a href="#">Se déconnecter</a></li>
        </ul>
    </div>
<main>

    @yield('content')
<main>

<script>
var flag = false;
var menu = document.getElementById("hidden-menu");
document.getElementById("user-navbar").addEventListener("click",function(){
    if (!flag){
        menu.getElementsByTagName("li")[0].setAttribute("style","display:block");
        menu.getElementsByTagName("li")[1].setAttribute("style","display:block");
        document.getElementById("hidden-menu").style.visibility='visible';
        document.getElementById("hidden-menu").style.height='60px';
        document.getElementById("hidden-menu").style.transition="0.25s";
        flag=true;
    } else {
        menu.getElementsByTagName("li")[0].setAttribute("style","display:none");
        menu.getElementsByTagName("li")[1].setAttribute("style","display:none");
        document.getElementById("hidden-menu").style.visibility='hidden';
        document.getElementById("hidden-menu").style.height = "0";
        flag=false;
}
        
});
</script>
@yield('javascript')
</body
</html>