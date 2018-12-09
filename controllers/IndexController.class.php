<?php


class IndexController
{

    public function indexAction()
    {

        $game = new Game();
        $game->id = 1;
        $game->hydrate();

        $views = DIRNAME . '/views'; // it uses the folder /views to read the templates
        $cache = DIRNAME . '/cache'; // it uses the folder /cache to compile the result.
        $blade=new \eftec\bladeone\BladeOne("./views/", "./cache/", \eftec\bladeone\BladeOne::MODE_AUTO);
        echo $blade->run("hello",array("game"=>$game));
    }

}