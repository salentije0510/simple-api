<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Http\Routing;

use ArrayObject;
use Frontify\ColorApi\Factories\RepositoryFactory;
use Frontify\ColorApi\Factories\RequestFactory;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
    private ArrayObject $routes;

    private UrlMaker $urlMaker;

    public function __construct(array $routes = [])
    {
        $this->routes = new \ArrayObject();

        foreach ($routes as $route) {
            $this->add($route);
        }
    }

    private function add(Route $route): void
    {
        $this->routes->offsetSet($route->getName(), $route);
    }

    /**
     * @throws \Exception
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

        throw new \Exception(
            sprintf('Route with the name = %s not found', $serverRequest->getMethod()),
            404
        );
    }

    public function generateUri(string $name, array $parameters = []): string
    {
        return $this->urlMaker->generate($name, $parameters);
    }

    public function run(ServerRequestInterface $request): array
    {
        $route = $this->matchFromPath($request);

        $pathVariables = $route->getAttributes();

        $controllerClass = $route->getHandler()->getControllerClass();
        $methodName = $route->getHandler()->getMethod();

        if (!class_exists($controllerClass) ||
            !method_exists($controllerClass, $methodName)) {
            throw new \Exception(
                sprintf('Unable to map route to the %s class and method %s', $controllerClass, $methodName)
            );
        }

        // For now simple and stupid. It can be improved by adding DI container to handle DI to controller class
        $repository = RepositoryFactory::make($controllerClass);

        $controller = new $controllerClass($repository);

        $request = RequestFactory::make($controllerClass, $methodName, $pathVariables, $request);

        return $controller->$methodName($request);
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
