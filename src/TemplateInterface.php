<?php

namespace JetFire\Template;


interface TemplateInterface {


    public function __construct(View $view,$options = []);
    public function render();

} 