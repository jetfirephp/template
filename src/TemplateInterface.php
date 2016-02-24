<?php

namespace JetFire\Template;


/**
 * Interface TemplateInterface
 * @package JetFire\Template
 */
interface TemplateInterface {

    /**
     * @param array $options
     */
    public function __construct($options = []);

    /**
     * @param View $view
     * @return mixed
     */
    public function render(View $view);

    /**
     * @param null $key
     * @return mixed
     */
    public function getTemplate($key = null);

} 