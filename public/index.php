<?php

declare(strict_types=1);

use Infrastructure\Adapters\Handlers\HttpError as HttpErrorHandler;
use Infrastructure\Adapters\Handlers\Shutdown as ShutdownHandler;
use Laminas\Config\Config;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

use function Infrastructure\Adapters\Support\basePath;
use function Infrastructure\Adapters\Support\configPath;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(basePath());
$dotenv->safeLoad();

// Set that to your needs
$displayErrorDetails = true;

// Build PHP-DI Container instance
$container = require configPath('container.php');
$config = $container
    ->get(Config::class)
    ->get('config');

// Set that to your needs
$displayErrorDetails    = $config->log->display_error_details;
$logErrors              = $config->log->log_errors;
$logErrorsDetails       = $config->log->log_error_details;

AppFactory::setContainer($container);
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
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logErrors, $logErrorsDetails);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Register middleware
$middleware = require configPath('middleware.php');
$middleware($app);

// Register routes
$routes = require configPath('routes.php');
$routes($app);

$app->run();
