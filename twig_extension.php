<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TwigExtension
 *
 * @author maguirre
 */
class TwigExtension extends Twig_Extension
{

    public function initRuntime(Twig_Environment $environment)
    {
        $environment->registerUndefinedFunctionCallback(array($this, 'callPhpFunction'));
    }

    public function getName()
    {
        return 'kumbia_extension';
    }

    public function getGlobals()
    {
        return array(
            'START_TIME' => START_TIME,
            'PRODUCTION' => PRODUCTION,
            'APP_PATH' => APP_PATH,
            'PUBLIC_PATH' => PUBLIC_PATH,
        );
    }

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('*_*', array($this, 'callHelper'), array(
                'is_safe' => array('html'),
                    )),
            new Twig_SimpleFunction('kumbia_version', 'kumbia_version'),
        );
    }

    public function callHelper($class, $method)
    {
        $args = func_get_args();
        unset($args[0], $args[1]);
        
        if (function_exists("{$class}_{$method}")) {
            $call = "{$class}_{$method}";
        } else {
            $call = "{$class}::{$method}";
        }
        
        return call_user_func_array($call, $args);
    }

    public function callPhpFunction($function)
    {
        if (function_exists($function)) {
            return new Twig_Function_Function($function);
        }

        return false;
    }

}
