<?php
require_once "ObjectController.php"; 

class ObjectInfoController extends ObjectController{
    public $template = "info.twig";
    public function getContext():array
    {
        $context = parent::getContext();

        $context['is_info'] = true;

        return $context;
    }
}