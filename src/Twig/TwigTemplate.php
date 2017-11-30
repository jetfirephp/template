<?php

namespace JetFire\Template\Twig;


use JetFire\Template\TemplateInterface;
use JetFire\Template\View;
use Twig_Environment;
use Twig_ExtensionInterface;
use Twig_Loader_Array;
use Twig_Loader_Filesystem;

/**
 * Class TwigTemplate
 * @package JetFire\Template\Twig
 */
class TwigTemplate implements TemplateInterface
{

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
     * @var array
     */
    private $extensions = [
        'Twig_Extension_Debug'
    ];

    /**
     * @param array $options
     * @throws \Exception
     */
    public function __construct($options = [])
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * @param null $key
     * @return array
     */
    public function getTemplate($key = null)
    {
        return (!is_null($key) && isset($this->template[$key])) ? $this->template[$key] : $this->template;
    }

    /**
     * @param View $view
     * @return Twig_Loader_Filesystem
     */
    private function loadTemplate($view)
    {
        $this->template['response'] = 'template';
        $loader  = new Twig_Loader_Filesystem();
        foreach ($view->getPath() as $key => $path){
            is_string($key) ? $loader->addPath($path, $key) : $loader->addPath($path);
        }
        return $loader;
    }

    /**
     * @param View $view
     * @return Twig_Loader_Array
     */
    private function loadContent($view)
    {
        $this->template['response'] = 'content';
        return (is_array($view->getContent()))
            ? new Twig_Loader_Array($view->getContent())
            : new Twig_Loader_Array(array(
                'content' => $view->getContent(),
            ));
    }

    /**
     * @param View $view
     * @throws \Exception
     */
    private function init($view)
    {
        if (!is_null($view->getTemplate())) {
            $loader = $this->loadTemplate($view);
        } elseif (!is_null($view->getContent())) {
            $loader = $this->loadContent($view);
        }
        if (isset($loader)) {
            $this->template['loader'] = $loader;
            $this->template['engine'] = new Twig_Environment($loader, $this->options);
        } else {
            throw new \Exception('Loader not found for Twig template');
        }
    }

    /**
     * @param View $view
     * @return null
     */
    public function render(View $view)
    {
        $this->init($view);
        $this->callExtensions();
        switch ($this->template['response']) {
            case 'template':
                return $this->template['engine']->render($view->getTemplate(), $view->getData());
                break;
            case 'content':
                return $this->template['engine']->render('content', $view->getData());
                break;
        }
        return null;
    }

    /**
     * @param $class
     * @return mixed|void
     */
    public function addExtension($class)
    {
        if ($class instanceof Twig_ExtensionInterface) {
            $this->extensions[] = function () use ($class) {
                return $class;
            };
        }
    }

    /**
     *
     */
    public function callExtensions()
    {
        foreach ($this->extensions as $extension) {
            (is_callable($extension))
                ? $this->template['engine']->addExtension(call_user_func($extension))
                : $this->template['engine']->addExtension(new $extension);
        }
    }
} 