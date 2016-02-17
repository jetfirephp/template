<?php

namespace JetFire\Template\Php;


/**
 * Class PhpTemplateEngine
 * @package JetFire\Template\Php
 */
class PhpTemplateEngine {

    /**
     * @param $content
     * @param array $data
     * @return bool
     */
    public function renderContent($content,$data = []){
        extract($data);
        file_put_contents(__DIR__.'/tmp.php',$content);
        require __DIR__.'/tmp.php';
        unlink(__DIR__.'/tmp.php');
        return true;
    }

    /**
     * @param $template
     * @param array $data
     * @return mixed
     */
    public function renderTemplate($template,$data = []){
        extract($data);
        return require($template);
    }

} 