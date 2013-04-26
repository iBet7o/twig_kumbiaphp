<?php

/**
 * @see KumbiaView
 */
require_once CORE_PATH . 'kumbia/kumbia_view.php';
require_once './Twig/lib/Twig/Autoloader.php';

/**
 * Esta clase permite extender o modificar la clase ViewBase de Kumbiaphp.
 *
 * @category KumbiaPHP
 * @package View
 */
class View extends KumbiaView
{

    public static function render($controller, $_url)
    {

        // Guarda el controlador actual
        self::$_controller = $controller;

        if (!self::$_view) {
            return ob_end_flush();
        }

        Twig_Autoloader::register();

        $loader = new Twig_Loader_Filesystem(self::$_path);

        $twig = new Twig_Environment($loader, array(
            'cache' => APP_PATH . 'temp/cache/twig',
            'debug' => !PRODUCTION,
        ));


        if (self::$_view) {
            echo $twig->render(self::$_view . '.twig', self::getVar());
        }
    }

}
