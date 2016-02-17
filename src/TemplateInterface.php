<?php

namespace JetFire\Template;


/**
 * Interface TemplateInterface
 * @package JetFire\Template
 */
interface TemplateInterface {

    /**
     * @param View $view
     * @param array $options
     */
    public function __construct(View $view,$options = []);

    /**
     * @return mixed
     */
    public function render();

    /**
     * @param null $key
     * @return mixed
     */
    public function getTemplate($key = null);

} 