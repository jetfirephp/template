<?php

namespace JetFire\Template\Php;

use JetFire\Template\TemplateInterface;
use JetFire\Template\View;

/**
 * Class PhpTemplate
 * @package JetFire\Template\Php
 */
class PhpTemplate implements TemplateInterface{

    /**
     * @var array
     */
    private $template = [];
    /**
     * @var array
     */
    private $options = [
        'cache' => false,
        'debug' => true,
        'charset' => 'utf-8',
    ];

    /**
     * @param array $options
     */
    public function __construct($options = []){
        $this->template['engine'] = new PhpTemplateEngine();
        $this->options = array_merge($this->options,$options);
    }

    /**
     * @param null $key
     * @return array
     */
    public function getTemplate($key = null){
        return is_null($key)?$this->template:$this->template[$key];
    }

    /**
     * @param View $view
     * @return null
     */
    public function render(View $view)
    {
        if(!is_null($view->getContent())){
            return $this->template['engine']->renderContent($view->getContent(),$view->getData());
        }elseif(!is_null($view->getTemplate())) {
            return $this->template['engine']->renderTemplate($view->getFullPath(),$view->getData());
        }
        return null;
    }



}