<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Routing;

use ArrayObject;
use Frontify\ColorApi\Exceptions\RouterException;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
    private ArrayObject $routes;

    private UrlMaker $urlMaker;

    public static function make(array $routes): self
    {
        return new self($routes);
    }

    public function __construct(array $routes = [])
    {
        //Could create class RouteCollection instead of using build in ArrayObject class
        $this->routes = new ArrayObject();

        foreach ($routes as $route) {
            $this->routes->offsetSet($route->getName(), $route);
        }
    }

    /**
     * @throws RouterException
     */
    public function matchFromPath(ServerRequestInterface $serverRequest): Route
    {
        foreach ($this->routes as $route) {
            /** @var Route $route */
            if (!$route->match($serverRequest->getUri()->getPath(), $serverRequest->getMethod())) {
                continue;
            }

            return $route;
        }

        throw new RouterException(sprintf('Route with the name = %s not found', $serverRequest->getMethod()));
    }

    public function generateUri(string $name, array $parameters = []): string
    {
        return $this->urlMaker->generate($name, $parameters);
    }

    public function getRoutes(): ArrayObject
    {
        return $this->routes;
    }

    public function setUrlMaker(UrlMaker $urlMaker): void
    {
        $this->urlMaker = $urlMaker;
    }
}
