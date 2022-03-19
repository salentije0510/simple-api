<?php declare(strict_types=1);

/* (c) Copyright Frontify Ltd., all rights reserved. */

use Frontify\ColorApi\Http\Routing\Router;
use Frontify\ColorApi\Http\Routing\UrlMaker;
use Sunrise\Http\ServerRequest\ServerRequestFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$routes = require_once __DIR__ . '/../routes/api/routes.php';

$request = ServerRequestFactory::fromGlobals();
header('Content-Type: application/json');
$urlMaker = new UrlMaker($routes);

return (new Router($urlMaker, $routes))->run($request);
