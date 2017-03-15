<?php

namespace Ilpaijin\Controller;

use Ilpaijin\DIContainer;

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
     * @param DIContainer $container
     */
    public function __construct(DIContainer $container)
    {
        $this->container = $container;
    }
}