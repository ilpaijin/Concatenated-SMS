<?php

use Ilpaijin\Application;

$app = new Application(new \Ilpaijin\DIContainer());

$app->routes['messages'] = 'MessageController';
$app->routes['balances'] = 'BalanceController';

$app->container->set('validator', new Ilpaijin\Validator\Validator);
$app->container->set('queue', new Ilpaijin\Service\Queue);

return $app;