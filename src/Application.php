<?php

declare(strict_types=1);

namespace Frontify\ColorApi;

use Exception;
use Frontify\ColorApi\Factories\RepositoryFactory;
use Frontify\ColorApi\Factories\RequestFactory;
use Frontify\ColorApi\Requests\BaseRequest;
use Frontify\ColorApi\Routing\Route;
use Frontify\ColorApi\Routing\Router;
use Frontify\ColorApi\Routing\UrlMaker;
use Sunrise\Http\ServerRequest\ServerRequest;

class Application
{
    public const PROJECT_ROOT_PATH = __DIR__ . '/../';

    private static ?self $instance = null;

    private array $routes = [];
    private ?Route $route = null;
    private ?Router $router = null;
    private array $response = [];

    private string $routesPath = 'routes/api/routes.php';

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->loadEnv();

        if (getenv('SEED_DATABASE') === 'true') {
            require __DIR__ . '/../database/insertTestData.php';
        }
    }

    public function boot(): self
    {
        $this->includeRoutes();

        $this->getRouterInstance();

        return $this;
    }

    /**
     * @throws Exceptions\RouterException
     */
    public function resolveRequest(ServerRequest $request): self
    {
        $this->route = $this->router->matchFromPath($request);

        if (!$this->authorization($request)) {
            return $this;
        }

        $pathVariables = $this->route->getAttributes();

        [$controllerClass, $methodName] = $this->route->getHandler();

        // For now simple and stupid. It can be improved by adding DI container or even using the Reflection to figure out necessary dependencies and method params
        $repository = RepositoryFactory::make($controllerClass);

        $controller = new $controllerClass($repository);

        $resolvedRequest = RequestFactory::make($controllerClass, $methodName, $pathVariables, $request);

        $this->response = $controller->$methodName($resolvedRequest);

        return $this;
    }

    // Should be placed in middleware class but for now left here just to have some sort of authorization
    private function authorization(ServerRequest $request): bool
    {
        if ($this->route->getOptions()['auth']) {
            $authHeader = $request->getHeader('Authorization');

            $headerPeaces = explode(' ', $authHeader[0]);
            $decodedHeader = base64_decode($headerPeaces[1]);

            [$username, $token] = explode(':', $decodedHeader);

            if (!Auth::user($username, $token)) {
                $this->response = ['success' => false, 'message' => 'Invalid credentials!'];
                return false;
            }
        }

        return true;
    }

    private function includeRoutes(): void
    {
        $routesFile = sprintf('%s/%s', self::PROJECT_ROOT_PATH, $this->routesPath);
        if (!file_exists($routesFile)) {
            throw new Exception(sprintf('File %s does not exist', $this->routesPath));
        }

        $this->routes = require $routesFile;
    }

    private function getRouterInstance(): void
    {
        $this->router = Router::make($this->routes);
        $this->router->setUrlMaker(UrlMaker::make($this->routes));
    }

    private function loadEnv(): void
    {
        DotEnvLoader::load();
    }

    public function sendResponse(): string
    {
        try {
            return json_encode($this->response, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new Exception('Something went wrong');
        }
    }
}
