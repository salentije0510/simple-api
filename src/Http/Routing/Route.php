<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Http\Routing;

class Route
{
    use RouteTrait;

    public const HTTP_METHOD_GET = 'GET';
    public const HTTP_METHOD_POST = 'POST';
    public const HTTP_METHOD_PUT = 'PUT';
    public const HTTP_METHOD_DELETE = 'DELETE';
    public const HTTP_METHOD_PATCH = 'PATCH';
    public const HTTP_METHOD_HEAD = 'HEAD';
    public const HTTP_METHOD_OPTIONS = 'OPTIONS';

    /** @var string  */
    private $name;

    /** @var string  */
    private $path;

    /** @var Handler */
    private $handler;

    /** @var string  */
    private $method;

    /** @var array<string, mixed>  */
    private $attributes = [];

    public function __construct(string $name, string $path, Handler $handler, string $method)
    {
        $this->name = $name;
        $this->path = $path;
        $this->handler = $handler;
        $this->method = $method;
    }

    public function match(string $path, string $method): bool
    {
        $regex = $this->path;

        foreach ($this->getPathVariables() as $variableName) {
            $varName = trim($variableName, '{\}');
            $regex = str_replace($variableName, '(?P<' . $varName . '>[^/]++)', $regex);
        }

        if ($method !== $this->method ||
            !preg_match(
                sprintf('#^%s$#sD', $regex),
                sprintf('/%s', rtrim(ltrim(trim($path), '/'), '/')),
                $matches
            )
        ) {
            return false;
        }

        $values = array_filter($matches, static function ($key) {
            return \is_string($key);
        }, ARRAY_FILTER_USE_KEY);

        foreach ($values as $key => $value) {
            $this->attributes[$key] = $value;
        }

        return true;
    }

    public function getPathVariables(): array
    {
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

    public function getHandler(): Handler
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
}
