<?php

namespace JetFire\Template\Twig;


use JetFire\Template\TemplateInterface;
use JetFire\Template\View;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Array;
use Twig_Loader_Filesystem;

class TwigTemplate implements TemplateInterface{

    private $template;
    private $view;
    private $response;

    private $options = [
        'cache' => false,
        'debug' => true,
        'charset' => 'utf-8',
    ];

    public function __construct(View $view,$options = []){
        $this->view = $view;
        $this->options = array_merge($this->options,$options);
        $this->init();
    }

    private function loadTemplate(){
        $this->response = 'template';
        return new Twig_Loader_Filesystem($this->view->getPath());
    }

    private function loadContent(){
        $this->response = 'content';
        return new Twig_Loader_Array(array(
            'content' => $this->view->getContent(),
        ));
    }

    private function init(){
        if(!is_null($this->view->getTemplate()))
            $loader = $this->loadTemplate();
        elseif(!is_null($this->view->getContent()))
            $loader = $this->loadContent();
        if(isset($loader)) {
            $this->template = new Twig_Environment($loader, array(
                'cache'   => $this->options['cache'],
                'debug'   => $this->options['debug'],
                'charset' => $this->options['charset']
            ));
            $this->template->addExtension(new Twig_Extension_Debug());
        }else
            throw new \Exception('Loader not found for Twig template');
    }

    public function render(){
        switch($this->response){
            case 'template':
                return $this->template->render($this->view->getTemplate(), $this->view->getData());
                break;
            case 'content':
                return $this->template->render('content', $this->view->getData());
                break;
        }
        return null;
    }

    public function renderTemplate($path,$data){
        echo $this->template->render($path, $data);
    }

} 