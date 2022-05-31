<?php

declare(strict_types=1);

namespace Infrastructure\Factories;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;

final class JsonResponseFactory
{
    public function __invoke(): ResponseInterface
    {
        return new JsonResponse([]);
    }
}
