<?php

use Ilpaijin\Application;

$container = new \Ilpaijin\DIContainer();
$app = new Application($container);

$app->routes['messages'] = 'MessageController';

$app->container->set('messagebird', new MessageBird\Client());

return $app;