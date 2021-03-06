<?php

declare(strict_types=1);

namespace Config;

use DI\ContainerBuilder;

use function Infrastructure\Adapters\Support\cachePath;
use function Infrastructure\Adapters\Support\configPath;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(configPath() . 'config.php');
$containerBuilder->addDefinitions([
    \Psr\Log\LoggerInterface::class => function (): \Psr\Log\LoggerInterface {
        $logger = new \Monolog\Logger('app');
        $logger->pushHandler(new \Monolog\Handler\StreamHandler('php://stderr', \Monolog\Logger::NOTICE));

        return $logger;
    },
]);

// Should be set to true in production
if (false) {
    $containerBuilder->enableCompilation(cachePath());
}

return $containerBuilder->build();
