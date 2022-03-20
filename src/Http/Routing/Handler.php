<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Http\Routing;

class Handler
{
    private string $controllerClass;

    public function __construct(string $controllerClass, private string $method)
    {
        if (!\is_callable($controllerClass, true)) {
            throw new \Exception(sprintf('Invalid class name = %s', $controllerClass));
        }

        $this->controllerClass = $controllerClass;
    }

    public function getControllerClass(): string
    {
        return $this->controllerClass;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}
