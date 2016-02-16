<?php

namespace JetFire\Template\Php;


class PhpTemplateEngine {

    public function renderContent($content,$data = []){
        extract($data);
        file_put_contents(__DIR__.'/tmp.php',$content);
        require __DIR__.'/tmp.php';
        unlink(__DIR__.'/tmp.php');
        return true;
    }

    public function renderTemplate($template,$data = []){
        extract($data);
        return require($template);
    }

} 