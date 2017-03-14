<?php

namespace Ilpaijin\Controller;

use Exception;

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
        try{
            $balance = $this->container->get('messagebird')->balance->read();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }

        return $balance->amount;
    }

    public function post() {

    }
}