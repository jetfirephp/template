<?php

namespace JetFire\Template\Twig;


use JetFire\Template\TemplateInterface;
use JetFire\Template\View;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Array;
use Twig_Loader_Filesystem;

/**
 * Class TwigTemplate
 * @package JetFire\Template\Twig
 */
class TwigTemplate implements TemplateInterface{

    /**
     * @var array
     */
    private $template = [];
    /**
     * @var View
     */
    private $view;

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
     * @throws \Exception
     */
    public function __construct(View $view,$options = []){
        $this->view = $view;
        $this->options = array_merge($this->options,$options);
        $this->init();
    }

    /**
     * @param null $key
     * @return array
     */
    public function getTemplate($key = null){
        return is_null($key)?$this->template:$this->template[$key];
    }


    /**
     * @return Twig_Loader_Filesystem
     */
    private function loadTemplate(){
        $this->template['response'] = 'template';
        return new Twig_Loader_Filesystem($this->view->getPath());
    }

    /**
     * @return Twig_Loader_Array
     */
    private function loadContent(){
        $this->template['response'] = 'content';
        return new Twig_Loader_Array(array(
            'content' => $this->view->getContent(),
        ));
    }

    /**
     * @throws \Exception
     */
    private function init(){
        if(!is_null($this->view->getTemplate()))
            $loader = $this->loadTemplate();
        elseif(!is_null($this->view->getContent()))
            $loader = $this->loadContent();
        if(isset($loader)) {
            $this->template['loader'] = $loader;
            $this->template['engine'] = new Twig_Environment($loader, array(
                'cache'   => $this->options['cache'],
                'debug'   => $this->options['debug'],
                'charset' => $this->options['charset']
            ));
            $this->template['engine']->addExtension(new Twig_Extension_Debug());
        }else
            throw new \Exception('Loader not found for Twig template');
    }

    /**
     * @return null
     */
    public function render(){
        switch($this->template['response']){
            case 'template':
                return $this->template['engine']->render($this->view->getTemplate(), $this->view->getData());
                break;
            case 'content':
                return $this->template['engine']->render('content', $this->view->getData());
                break;
        }
        return null;
    }
} 