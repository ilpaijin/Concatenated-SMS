<?php

use Ilpaijin\Application;

$app = new Application(new \Ilpaijin\DIContainer());

$app->routes['messages'] = 'MessageController';
$app->routes['balances'] = 'BalanceController';

$app->container->set('messagebird', new MessageBird\Client("clBHUTYfRaDwHdJl6yy3npYf7"));

return $app;