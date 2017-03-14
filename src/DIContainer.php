<?php

namespace Ilpaijin;

/**
 * Class DIContainer
 * @package Ilpaijin
 */
class DIContainer
{
    /**
     * @var array
     */
    private $services = [];

    /**
     * @param $name
     * @return mixed | null
     */
    public function get($name)
    {
        return isset($this->services[$name]) ? $this->services[$name] : null;
    }

    /**
     * @param $name
     * @param $service
     */
    public function set($name, $service)
    {
        $this->services[$name] = $service;
    }
}