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
     * @var View
     */
    private $view;
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
     * @param View $view
     * @param array $options
     */
    public function __construct(View $view,$options = []){
        $this->view = $view;
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
     * @return null
     */
    public function render()
    {
        if(!is_null($this->view->getContent())){
            return $this->template['engine']->renderContent($this->view->getContent(),$this->view->getData());
        }elseif(!is_null($this->view->getTemplate())) {
            return $this->template['engine']->renderTemplate($this->view->getFullPath(),$this->view->getData());
        }
        return null;
    }



}