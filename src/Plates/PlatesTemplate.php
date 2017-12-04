<?php

namespace JetFire\Template\Plates;

use JetFire\Template\TemplateInterface;
use JetFire\Template\View;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class PlatesTemplate implements TemplateInterface
{

    /**
     * @var array
     */
    private $template = [];

    /**
     * @var array
     */
    private $options = [];
    /**
     * @var array
     */
    private $extensions = [];

    /**
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->options = $options;
    }

    /**
     * @param \JetFire\Template\View $view
     * @return mixed
     */
    public function render(View $view)
    {
        $this->init($view);
        return $this->template['engine']->render(str_replace($view->getExtension(), '', $view->getTemplate()), $view->getData());
    }

    /**
     * @param null $key
     * @return mixed
     */
    public function getTemplate($key = null)
    {
        return (!is_null($key) && isset($this->template[$key])) ? $this->template : $this->template[$key];
    }

    /**
     * @param $class
     * @return mixed|void
     */
    public function addExtension($class)
    {
        if ($class instanceof ExtensionInterface) {
            $this->extensions[] = function () use ($class) {
                return $class;
            };
        }
    }

    /**
     * @param View $view
     * @throws \Exception
     */
    private function init($view)
    {
        $paths = current($view->getPath());
        $this->template['engine'] = new Engine($paths, ltrim($view->getExtension(), '.'));
        foreach ($view->getPath() as $key => $path) {
            is_string($key)
                ? $this->template['engine']->addFolder($key, $path, true)
                : $this->template['engine']->addFolder('path_' . $key, $path, true);
        }
        foreach ($this->extensions as $extension)
            (is_callable($extension))
                ? $this->template['engine']->loadExtension(call_user_func($extension))
                : $this->template['engine']->loadExtension(new $extension);
    }
}