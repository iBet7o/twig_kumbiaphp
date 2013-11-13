<?php

/**
 * @see KumbiaView
 */
require_once CORE_PATH . 'kumbia/kumbia_view.php';
require_once __DIR__ . '/twig_kumbiaphp/Twig/lib/Twig/Autoloader.php';

/**
 * Esta clase permite extender o modificar la clase ViewBase de Kumbiaphp.
 *
 * @category KumbiaPHP
 * @package View
 */
class View extends KumbiaView
{

    /**
     * Devuelve un singleton de Twig
     * @staticvar Twig_Environment $twig
     * @return Twig_Environment
     */
    public static function getTwig()
    {
        static $twig;

        if (!$twig) {
            Twig_Autoloader::register();

            $loader = new Twig_Loader_Filesystem(array());

            $loader->addPath(APP_PATH . 'views/_shared/templates', 'templates');
            $loader->addPath(APP_PATH . 'views/_shared/partials', 'partials');
            $loader->addPath(APP_PATH . 'views/_shared/scaffolds', 'scaffolds');
            $loader->addPath(APP_PATH . 'views');

            $twig = new Twig_Environment($loader, array(
                'cache' => APP_PATH . 'temp/cache/twig',
                'debug' => !PRODUCTION,
                    //'strict_variables' => !PRODUCTION,
            ));

            if (!PRODUCTION) {
                $twig->addExtension(new Twig_Extension_Debug());
            }

            $twig->addExtension(new TwigExtension());
            $twig->addExtension(new TwigExtensionForm(new PropertyAccessor()));
            $twig->addExtension(new TwigExtensionScaffold());
        }

        return $twig;
    }

    public static function render($controller, $_url)
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
        if (isset($scaffold)) {
            if (!$loader->exists($view)) {
                $view = "@scaffolds/$scaffold/" . self::$_view . '.twig';
            }
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

}
