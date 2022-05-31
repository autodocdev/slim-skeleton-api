<?php

declare(strict_types=1);
use Laminas\Config\Config;
use Slim\App;

return function (App $app) {
    $app->setBasePath('/' . $app->getContainer()->get(Config::class)->get('config')->baseUrl);
    $app->get('/ping', Infrastructure\Controllers\PingController::class);
};
