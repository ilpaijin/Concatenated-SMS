<?php

namespace Ilpaijin\Controller;

/**
 * Class BaseController
 * @package Ilpaijin\Controller
 */
class ControllerDIAware
{
    /**
     * @var
     */
    protected $container;

    /**
     * ControllerDIAware constructor.
     * @param $app
     */
    public function __construct($container)
    {
        $this->container = $container;
    }
}