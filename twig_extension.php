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

    public function getName()
    {
        return 'kumbia_extension';
    }

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('css', array($this, 'css'), array('is_safe' => array('html'))),
            new Twig_SimpleFunction('js', array($this, 'js'), array('is_safe' => array('html'))),
            new Twig_SimpleFunction('url', array($this, 'asset')),
            new Twig_SimpleFunction('asset', array($this, 'asset')),
            new Twig_SimpleFunction('link', array('Html', 'link'), array('is_safe' => array('html'))),
            new Twig_SimpleFunction('link_action', array('Html', 'linkAction'), array('is_safe' => array('html'))),
            new Twig_SimpleFunction('img', array('Html', 'img'), array('is_safe' => array('html'))),
            new Twig_SimpleFunction('view_content', array('View', 'content'), array('is_safe' => array('html'))),
        );
    }

    public function css($css, $media = 'screen')
    {
        return '<link href="' . PUBLIC_PATH . "css/{$css}.css\" rel=\"stylesheet\" type=\"text/css\" media=\"{$media}\" />";
    }

    public function js($src, $cache = TRUE)
    {
        $src = "javascript/$src.js";
        if (!$cache) {
            $src .= '?nocache=' . uniqid();
        }

        return '<script type="text/javascript" src="' . PUBLIC_PATH . $src . '"></script>';
    }

    public function asset($path)
    {
        return rtrim(PUBLIC_PATH, '/') . '/' . ltrim($path, '/');
    }

    public function link()
    {
        return call_user_func_array(array('Html', 'link'), func_get_args());
    }

    public function linkAction()
    {
        return call_user_func_array(array('Html', 'linkAction'), func_get_args());
    }

    public function img()
    {
        return call_user_func_array(array('Html', 'img'), func_get_args());
    }

}
