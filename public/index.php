<?php

declare(strict_types=1);

use Infrastructure\Handlers\HttpError as HttpErrorHandler;
use Infrastructure\Handlers\Shutdown as ShutdownHandler;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

use function Infrastructure\Adapters\Support\basePath;
use function Infrastructure\Adapters\Support\configPath;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(basePath());
$dotenv->safeLoad();

// Set that to your needs
$displayErrorDetails = true;

$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();
$responseFactory = $app->getResponseFactory();

$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Error Handling Middleware
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, false, false);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Register middleware
$middleware = require configPath() . 'middleware.php';
$middleware($app);

// Register routes
$routes = require configPath() . 'routes.php';
$routes($app);

$app->run();
