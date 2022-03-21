<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Routing;

trait RouteTrait
{
    public static function get(string $name, string $path, Handler $handler): Route
    {
        return self::make($name, $path, $handler, Route::HTTP_METHOD_GET);
    }

    public static function post(string $name, string $path, Handler $handler): Route
    {
        return self::make($name, $path, $handler, Route::HTTP_METHOD_POST);
    }

    public static function put(string $name, string $path, Handler $handler): Route
    {
        return self::make($name, $path, $handler, Route::HTTP_METHOD_PUT);
    }

    public static function delete(string $name, string $path, Handler $handler): Route
    {
        return self::make($name, $path, $handler, Route::HTTP_METHOD_DELETE);
    }

    public static function options(string $name, string $path, Handler $handler): Route
    {
        return self::make($name, $path, $handler, Route::HTTP_METHOD_OPTIONS);
    }

    private static function make(string $name, string $path, Handler $handler, string $method): Route
    {
        return new Route($name, $path, $handler, $method);
    }
}
