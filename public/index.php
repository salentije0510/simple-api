<?php declare(strict_types=1);

/* (c) Copyright Frontify Ltd., all rights reserved. */

require_once __DIR__ . '/../vendor/autoload.php';

$app = \Frontify\ColorApi\Application::getInstance();
echo $app
    ->boot()
    ->resolveRequest(\Sunrise\Http\ServerRequest\ServerRequestFactory::fromGlobals())
    ->sendResponse();
