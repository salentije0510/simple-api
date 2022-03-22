<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Routing;

use Frontify\ColorApi\Exceptions\RouterException;

class Route
{
    public const HTTP_METHOD_GET = 'GET';
    public const HTTP_METHOD_POST = 'POST';
    public const HTTP_METHOD_PUT = 'PUT';
    public const HTTP_METHOD_DELETE = 'DELETE';
    public const HTTP_METHOD_OPTIONS = 'OPTIONS';

    /** @var array<string, mixed>  */
    private array $attributes = [];

    public function __construct(
        private string $name,
        private string $path,
        private array $handler,
        private string $method,
        private array $options,
    ) {
        if (!class_exists($this->handler[0]) || !method_exists($this->handler[0], $this->handler[1])) {
            throw new RouterException(sprintf('Invalid handler provided for the route %s', $this->name));
        }
    }

    public static function get(string $name, string $path, array $handler, array $options): Route
    {
        return new self($name, $path, $handler, Route::HTTP_METHOD_GET, $options);
    }

    public static function post(string $name, string $path, array $handler, array $options): Route
    {
        return new self($name, $path, $handler, Route::HTTP_METHOD_POST, $options);
    }

    public static function put(string $name, string $path, array $handler, array $options): Route
    {
        return new self($name, $path, $handler, Route::HTTP_METHOD_PUT, $options);
    }

    public static function delete(string $name, string $path, array $handler, array $options): Route
    {
        return new self($name, $path, $handler, Route::HTTP_METHOD_DELETE, $options);
    }

    public static function options(string $name, string $path, array $handler, array $options): Route
    {
        return new self($name, $path, $handler, Route::HTTP_METHOD_OPTIONS, $options);
    }

    public function match(string $path, string $method): bool
    {
        $regex = $this->path;

        foreach ($this->getPathVariables() as $variableName) {
            $varName = trim($variableName, '{\}');
            // Building the named regular expression group based on the stripped path variables
            $regex = str_replace($variableName, '(?P<' . $varName . '>[^/]+)', $regex);
        }

        if (
            $method !== $this->method ||
            // checking if the regex build based on path variables matches path used to send request
            !preg_match(sprintf('#^%s$#sD', $regex), sprintf('/%s', trim($path, '/')), $matches)
        ) {
            return false;
        }

        $values = array_filter($matches, static fn ($key) => \is_string($key), ARRAY_FILTER_USE_KEY);

        foreach ($values as $key => $value) {
            $this->attributes[$key] = $value;
        }

        return true;
    }

    public function getPathVariables(): array
    {
        // Matches substrings in path that are between slashes inside the curly braces
        preg_match_all('/{[^}]*}/', $this->path, $matches);

        return reset($matches) ?? [];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getHandler(): array
    {
        return $this->handler;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function hasAttributes(): bool
    {
        return $this->getPathVariables() !== [];
    }

    /**
     * @return array<string, mixed>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return array<string, bool>
     * Can be used for passing route middlewares. For now only to check should the user by authenticated for the route
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
