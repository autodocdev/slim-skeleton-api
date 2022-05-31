<?php

declare(strict_types=1);

namespace Config;

use DI\ContainerBuilder;
use Infrastructure\Factories\ConfigFactory;
use Infrastructure\Factories\JsonResponseFactory;
use Infrastructure\Factories\LoggerFactory;
use Laminas\Config\Config;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

use function DI\factory;
use function Infrastructure\Adapters\Support\configPath;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(configPath('app.php'));
$containerBuilder->addDefinitions([
    Config::class               => factory(ConfigFactory::class),
    LoggerInterface::class      => factory(LoggerFactory::class),
    ResponseInterface::class    => factory(JsonResponseFactory::class),
]);

return $containerBuilder->build();
