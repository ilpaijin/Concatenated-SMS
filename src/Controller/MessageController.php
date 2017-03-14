<?php

namespace Ilpaijin\Controller;

/**
 * Class MessageController
 * @package Ilpaijin\Controller
 */
class MessageController extends ControllerDIAware
{
    /**
     * @return string
     */
    public function getAll()
    {
        var_dump($this->container->get('messagebird'));
        return "my message list!";
    }

    public function post() {

    }
}