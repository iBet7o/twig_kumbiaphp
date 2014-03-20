<?php

class KuTwig_Extension_Scaffold extends Twig_Extension
{

    public function getName()
    {
        return 'ku_scaffold';
    }

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('model_form', array('ModelForm', 'create'), array('is_safe' => array('html'))),
            new Twig_SimpleFunction('model_fields', array($this, 'modelFields')),
        );
    }

    public function getFilters()
    {
        return array();
    }

    public function modelFields(KumbiaActiveRecord $model)
    {
        return $model->fields;
    }

}
