<?php

declare(strict_types=1);

namespace Infrastructure;

use function dirname;
use function is_null;

use const DIRECTORY_SEPARATOR;

function basePath(?string $path = null): string
{
    if (is_null($path)) {
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR;
    }

    return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR;
}

function configPath(?string $path = null): string
{
    if (is_null($path)) {
        basePath('config') . DIRECTORY_SEPARATOR;
    }

    return basePath('config') . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR;
}

function varPath(?string $path = null): string
{
    if (is_null($path)) {
        basePath('var') . DIRECTORY_SEPARATOR;
    }

    return basePath('var') . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR;
}

function cachePath(?string $path = null): string
{
    if (is_null($path)) {
        varPath('cache') . DIRECTORY_SEPARATOR;
    }

    return varPath('cache') . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR;
}
