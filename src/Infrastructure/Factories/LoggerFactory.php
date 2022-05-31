<?php

declare(strict_types=1);

namespace Infrastructure\Factories;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

final class LoggerFactory
{
    public function __invoke(): LoggerInterface
    {
        $logger = new Logger('app');
        $logger->pushHandler(new StreamHandler('php://stderr', Logger::NOTICE));

        return $logger;
    }
}
