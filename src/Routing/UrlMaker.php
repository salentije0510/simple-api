<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Routing;

use ArrayObject;

class UrlMaker
{
    private ArrayObject $routes;

    public static function make(array $routeList): self
    {
        $routes = new ArrayObject();

        foreach ($routeList as $route) {
            $routes->offsetSet($route->getName(), $route);
        }

        return new self($routes);
    }

    public function __construct(ArrayObject $routes)
    {
        $this->routes = $routes;
    }

    public function generate(string $name, array $parameters = []): string
    {
        if (!$this->routes->offsetExists($name)) {
            throw new \InvalidArgumentException(sprintf('Unknown route %s', $name));
        }

        /** @var Route $route */
        $route = $this->routes[$name];

        if ($parameters === [] && $route->hasAttributes() === true) {
            throw new \InvalidArgumentException(
                sprintf('%s route requires following parameters: %s', $name, implode(',', $route->getPathVariables())),
            );
        }

        return $this->resolveUri($route, $parameters);
    }

    private function resolveUri(Route $route, array $parameters): string
    {
        $uri = $route->getPath();

        foreach ($route->getPathVariables() as $variable) {
            $variableName = trim($variable, '{\}');

            if (!\array_key_exists($variableName, $parameters)) {
                throw new \InvalidArgumentException(
                    sprintf('%s not found in parameters to generate url', $variableName),
                );
            }

            $uri = str_replace($variable, $parameters[$variableName], $uri);
        }

        return $uri;
    }
}
