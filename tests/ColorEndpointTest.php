<?php declare(strict_types=1);

/* (c) Copyright Frontify Ltd., all rights reserved. */

use Frontify\ColorApi\ColorEndpoint;
use PHPUnit\Framework\TestCase;
use Sunrise\Http\ServerRequest\ServerRequest;
use Sunrise\Uri\Uri;

final class ColorEndpointTest extends TestCase
{
    private const ENDPOINT = '/color';
    private const DATABASE_FILE_NAME = 'frontify-color-api-database.db';

    private $endpoint;

    protected function setUp(): void
    {
        $this->endpoint = new ColorEndpoint();
    }

    protected function tearDown(): void
    {
        unlink(sys_get_temp_dir() . '/' . self::DATABASE_FILE_NAME);
    }

    public function testGetWithNoData(): void
    {
        $request = $this->prophesize(ServerRequest::class);
        $uri = $this->prophesize(Uri::class);
        $request->getMethod()->willReturn('GET');
        $request->getUri()->willReturn($uri);
        $uri->getPath()->willReturn(self::ENDPOINT);

        self::assertEquals([], $this->endpoint->handle($request->reveal()));
    }

}
