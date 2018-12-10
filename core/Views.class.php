<?php

use \eftec\bladeone\BladeOne;

class Views
{
    public static function render($view, $variables = [])
    {
        $views = './views';
        $cache = './cache';

        $blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);

        echo $blade->run($view, $variables);
    }
}
