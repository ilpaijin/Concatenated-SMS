<?php

use Ilpaijin\Application;

$app = new Application();

$app->routes['messages'] = 'MessageController';

$app->services['messagebird'] = new MessageBird\Client();

return $app;