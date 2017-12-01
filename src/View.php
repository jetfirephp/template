<?php

namespace JetFire\Template;

/**
 * Class View
 * @package JetFire\Template
 */
class View
{

    /**
     * @var array
     */
    private $data = [];
    /**
     * @var array
     */
    private $path;
    /**
     * @var
     */
    private $content;
    /**
     * @var
     */
    private $template;
    /**
     * @var
     */
    private $extension;

    /**
     * @return null|string
     */
    public function getFullPath()
    {
        foreach ($this->getPath() as $dir) {
            if (is_file($path = $dir . $this->template . $this->extension)) {
                return $path;
            } elseif (is_file($path = $dir . $this->template)) {
                return $path;
            }
        }
        return null;
    }

    /**
     * @param null $key
     * @return array
     */
    public function getPath($key = null)
    {
        return is_null($key) ? $this->path : $this->path[$key];
    }

    /**
     * @param $path
     */
    public function setPath($path)
    {
        $this->path = is_array($path) ? $path : [rtrim($path, '/') . '/'];
    }

    /**
     * @param $key
     * @param $path
     */
    public function addPath($key, $path = null)
    {
        $path = is_null($path) ? $key : $path;
        $this->path[$key] = rtrim($path, '/') . '/';
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        foreach ($this->getPath() as $dir) {
            if (is_file($dir . ($path = $this->template . $this->extension))) {
                return $path;
            } elseif (is_file($dir . ($path = $this->template))) {
                return $path;
            }
        }
        return $this->template;
    }

    /**
     * @param $template
     */
    public function setTemplate($template)
    {
        $this->template = is_null($template) ? $template : ltrim($template, '/');
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * @param null $key
     * @return array
     */
    public function getData($key = null)
    {
        return is_null($key) ? $this->data : $this->data[$key];
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasData($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * @param array $data
     */
    public function setData($data = [])
    {
        $this->data = $data;
    }

    /**
     *
     */
    public function addData()
    {
        $args = func_get_args();
        (func_num_args() == 2)
            ? $this->data[$args[0]] = $args[1]
            : $this->data = array_merge($this->data, $args[0]);
    }
}