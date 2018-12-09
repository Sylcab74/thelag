<?php


class IndexController{

    public function indexAction($params){

        $distributeur = new Distributeur();
        $distributeur->id_distributeur = 5;
        $distributeur->hydrate();

        $views = DIRNAME . '/views'; // it uses the folder /views to read the templates
        $cache = DIRNAME . '/cache'; // it uses the folder /cache to compile the result.
        $blade=new \eftec\bladeone\BladeOne("./views/", "./cache/", \eftec\bladeone\BladeOne::MODE_AUTO);
        echo $blade->run("hello",array("distributeur"=>$distributeur));
    }

}