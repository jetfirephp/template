<?php

namespace JetFire\Template;

/**
 * Class View
 * @package JetFire\Template
 */
class View{

    /**
     * @var array
     */
    private $data = [];
    /**
     * @var
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
    public function getFullPath(){
        if(is_file($path = $this->path.$this->template.$this->extension))
            return $path;
        elseif(is_file($path = $this->path.$this->template))
            return $path;
        return null;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param $path
     */
    public function setPath($path)
    {
        $this->path = rtrim($path,'/').'/';
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        if(is_file($this->path.($path = $this->template.$this->extension)))
            return $path;
        elseif(is_file($this->path.($path = $this->template)))
            return $path;
        return $this->template;
    }

    /**
     * @param $template
     */
    public function setTemplate($template)
    {
        $this->template = is_null($template) ? $template :  ltrim($template,'/');
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
        return is_null($key)?$this->data:$this->data[$key];
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
            : $this->data = array_merge($this->data,$args[0]);
    }
}