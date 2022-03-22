<?php

declare(strict_types=1);

use Frontify\ColorApi\Controllers\ColorController;
use Frontify\ColorApi\Exceptions\RouterException;
use Frontify\ColorApi\Routing\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    private string $hasAttributePath = '/attribute/{id}';
    private string $hasAttributeMethod = 'GET';
    private Route $hasAttributeRoute;
    private string $hasAttributeRouteName = 'attribute_save';

    private string $noAttributePath = '/no-attribute/index';
    private string $noAttributeMethod = 'GET';
    private Route $noAttributeRoute;
    private string $noAttributeRouteName = 'attribute_index';

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->noAttributeRoute = new Route(
            $this->noAttributeRouteName,
            $this->noAttributePath,
            [ColorController::class, 'index'],
            $this->noAttributeMethod,
            []
        );

        $this->hasAttributeRoute = new Route(
            $this->hasAttributeRouteName,
            $this->hasAttributePath,
            [ColorController::class, 'index'],
            $this->hasAttributeMethod,
            []
        );
    }

    public function testInvalidRouteHandler(): void
    {
        $this->expectException(RouterException::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage('Routing error: Invalid handler provided for the route attribute_index');

        new Route('attribute_index', '/api/colors', ['Frontify\\ColorApi\\Controllers\\AttributeController', 'index'], Route::HTTP_METHOD_GET, []);
    }

    public function testNotMatchedRoute(): void
    {
        $this->assertFalse($this->noAttributeRoute->match('/colors', 'GET'));
        $this->assertFalse($this->noAttributeRoute->match('/colors/1', 'PUT'));
        $this->assertFalse($this->hasAttributeRoute->match('/colors/1/test', 'POST'));
    }

    public function testMatchRoute(): void
    {
        $this->assertTrue($this->hasAttributeRoute->match($this->hasAttributePath, $this->hasAttributeMethod));
        $this->assertTrue($this->noAttributeRoute->match($this->noAttributePath, $this->noAttributeMethod));

        $this->assertFalse($this->hasAttributeRoute->match($this->noAttributePath, $this->noAttributeMethod));
        $this->assertFalse($this->noAttributeRoute->match($this->hasAttributePath, $this->hasAttributeMethod));
    }

    public function testGetPathVariables(): void
    {
        $variables = $this->hasAttributeRoute->getPathVariables();
        $this->assertIsArray($variables);
        $this->assertCount(1, $variables);
        $this->assertEquals(['{id}'], $variables);

        $noVariables = $this->noAttributeRoute->getPathVariables();
        $this->assertIsArray($noVariables);
        $this->assertEmpty($noVariables);
    }

    public function testGetName(): void
    {
        $hasAttributeName = $this->hasAttributeRoute->getName();
        $this->assertIsString($hasAttributeName);
        $this->assertEquals($hasAttributeName, $this->hasAttributeRouteName);

        $noAttributeName = $this->noAttributeRoute->getName();
        $this->assertIsString($noAttributeName);
        $this->assertEquals($noAttributeName, $this->noAttributeRouteName);
    }

    public function testGetMethod(): void
    {
        $hasAttributeMethod = $this->hasAttributeRoute->getMethod();
        $this->assertIsString($hasAttributeMethod);
        $this->assertEquals($hasAttributeMethod, $this->hasAttributeMethod);

        $noAttributeMethod = $this->noAttributeRoute->getMethod();
        $this->assertIsString($noAttributeMethod);
        $this->assertEquals($noAttributeMethod, $this->noAttributeMethod);
    }
}