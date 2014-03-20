<?php

/*
 * This file is part of the Manuel Aguirre Project.
 *
 * (c) Manuel Aguirre <programador.manuel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of KuTwig_View
 *
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class KuTwig_View extends KumbiaView
{

    /**
     * Devuelve un singleton de Twig
     * @staticvar Twig_Environment $twig
     * @return Twig_Environment
     */
    public static function getTwig()
    {
        static $twig = null;

        if (!$twig) {

            $twig = new Twig_Environment(self::getTwigLoader(), static::getConfig());

            static::prepareTwig($twig);
        }

        return $twig;
    }

    public static function getTwigLoader()
    {
        static $loader = null;

        if (!$loader) {

            $loader = new Twig_Loader_Filesystem();

            self::prepareLoader($loader);
        }

        return $loader;
    }

    public static function render($controller)
    {
        // Guarda el controlador actual
        self::$_controller = $controller;
        self::$_content = ob_get_clean();

        if (!self::$_view) {
            return ob_end_flush();
        }

        // Mapea los atributos del controller en el scope
        extract(get_object_vars($controller), EXTR_OVERWRITE);

        $view = self::$_path . self::$_view . '.twig';

        // si se usa el scaffold verificamos la vista a usar.
        if (isset($scaffold) and !self::getTwigLoader()->exists($view)) {
            $view = "@scaffolds/$scaffold/" . self::$_view . '.twig';
        }

        self::getTwig()->display($view, self::getVar());
    }

    public static function _partial($context, $__partial, $params = array())
    {
        $__file = APP_PATH . 'partials/' . $__partial . '.php';

        extract($context, EXTR_OVERWRITE);
        extract($params, EXTR_OVERWRITE);

        if (!include $__file) {
            throw new KumbiaException("No existe el partial $__file");
        }
    }

    protected static function prepareTwig(Twig_Environment $twig)
    {
        if (!PRODUCTION) {
            $twig->addExtension(new Twig_Extension_Debug());
        }

        $twig->addExtension(new KuTwig_Extension_Extension());
        $twig->addExtension(new KuTwig_Extension_Form());
        $twig->addExtension(new KuTwig_Extension_Scaffold());
    }

    protected static function prepareLoader(Twig_Loader_Filesystem $loader)
    {
        $loader->addPath(APP_PATH . 'views/_shared/templates', 'templates');
        $loader->addPath(APP_PATH . 'views/_shared/partials', 'partials');
        $loader->addPath(APP_PATH . 'views/_shared/scaffolds', 'scaffolds');
        $loader->addPath(APP_PATH . 'views');
    }

    protected static function getConfig()
    {
        return array(
            'cache' => APP_PATH . 'temp/cache/twig',
            'debug' => !PRODUCTION,
            'strict_variables' => !PRODUCTION,
        );
    }

}
