<?php

namespace Ilpaijin\Controller;

/**
 * Class BalanceController
 * @package Ilpaijin\Controller
 */
class BalanceController extends ControllerDIAware
{
    /**
     * @return string
     */
    public function getAll()
    {
        try{
            $balance = $this->container->get('messagebird')->balance->read();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }

        return $balance->amount;
    }
}