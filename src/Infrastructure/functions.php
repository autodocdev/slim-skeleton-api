<?php

namespace Infrastructure;

const DS = DIRECTORY_SEPARATOR;

function base_path(string $path = null): string
{
    if (is_null($path)) {
        return dirname(__DIR__, 2) . DS;
    }

    return dirname(__DIR__, 2) . DS . $path . DS;
}

function config_path(string $path = null): string
{
    if (is_null($path)) {
        base_path("config") . DS;
    }

    return base_path("config") . DS . $path . DS;
}

function var_path(string $path = null): string
{
    if (is_null($path)) {
        base_path("var") . DS;
    }

    return base_path("var") . DS . $path . DS;
}

function cache_path(string $path = null): string
{
    if (is_null($path)) {
        var_path("cache") . DS;
    }

    return var_path("cache") . DS . $path . DS;
}
