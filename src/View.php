<?php

namespace JetFire\Template;

class View{

    private $data = [];
    private $path;
    private $content;
    private $template;
    private $extension;

    public function getFullPath(){
        if(is_file($path = $this->path.$this->template.$this->extension))
            return $path;
        elseif(is_file($path = $this->path.$this->template))
            return $path;
        return null;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = rtrim($path,'/').'/';
    }

    public function getTemplate()
    {
        if(is_file($this->path.($path = $this->template.$this->extension)))
            return $path;
        elseif(is_file($this->path.($path = $this->template)))
            return $path;
        return $this->template;
    }

    public function setTemplate($template)
    {
        $this->template = ltrim($template,'/');
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content )
    {
        $this->content = $content;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    public function getData($key = null)
    {
        return is_null($key)?$this->data:$this->data[$key];
    }

    public function setData($data = [])
    {
       $this->data = $data;
    }

    public function addData()
    {
        $args = func_get_args();
        (func_num_args() > 1)
            ? $this->data[$args[0]] = $args[1]
            : $this->data[] = $args[0];
    }
}