<?php

namespace JetFire\Template\Php;


use JetFire\Template\TemplateInterface;
use JetFire\Template\View;

class PhpTemplate implements TemplateInterface{

    private $view;
    private $template;
    private $options = [
        'cache' => false,
        'debug' => true,
        'charset' => 'utf-8',
    ];

    public function __construct(View $view,$options = []){
        $this->view = $view;
        $this->template = new PhpTemplateEngine();
        $this->options = array_merge($this->options,$options);
    }

    public function render()
    {
        if(!is_null($this->view->getContent())){
            return $this->template->renderContent($this->view->getContent(),$this->view->getData());
        }elseif(!is_null($this->view->getTemplate())) {
            return $this->template->renderTemplate($this->view->getFullPath(),$this->view->getData());
        }
        return null;
    }



}