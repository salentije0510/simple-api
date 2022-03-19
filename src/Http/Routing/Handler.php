<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Http\Routing;

class Handler
{
    /** @var string */
    private $controllerClass;

    /** @var string */
    private $method;

    public function __construct(string $controllerClass, string $method)
    {
        if (!\is_callable($controllerClass, true)) {
            throw new \Exception(sprintf('Invalid class name = %s', $controllerClass));
        }

        $this->controllerClass = $controllerClass;
        $this->method = $method;
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
