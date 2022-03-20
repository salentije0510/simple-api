<?php declare(strict_types=1);

/* (c) Copyright Frontify Ltd., all rights reserved. */


require __DIR__ . "/bootstrap.php";
$routes = require_once __DIR__ . '/../routes/api/routes.php';

$request = Sunrise\Http\ServerRequest\ServerRequestFactory::fromGlobals();

$router = new Frontify\ColorApi\Http\Routing\Router($routes);
$urlMaker = new Frontify\ColorApi\Http\Routing\UrlMaker($router->getRoutes());

return $router->run($request);
