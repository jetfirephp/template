<?php

namespace JetFire\Template\Php;

/**
 * Class PhpTemplateEngine
 * @package JetFire\Template\Php
 */
class PhpTemplateEngine
{

    /**
     * @var array
     */
    private $extensions = [];

    /**
     * @param $content
     * @param array $data
     * @return bool
     */
    public function renderContent($content, $data = [])
    {
        extract($data);
        file_put_contents(__DIR__ . '/tmp.php', $content);
        ob_start();
        require __DIR__ . '/tmp.php';
        $data = ob_get_clean();
        unlink(__DIR__ . '/tmp.php');
        return $data;
    }

    /**
     * @param $template
     * @param array $data
     * @return mixed
     */
    public function renderTemplate($template, $data = [])
    {
        extract($data);
        ob_start();
        require($template);
        return ob_get_clean();
    }

    /**
     * @param array $extension
     */
    public function addExtension($extension = [])
    {
        $this->extensions[] = $extension;
    }

    /**
     * @param $name
     * @param $args
     * @return mixed
     */
    public function __call($name, $args)
    {
        return call_user_func_array([$this->extensions, $name], $args);
    }

} 