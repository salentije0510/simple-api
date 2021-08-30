<?php declare(strict_types=1);

/* (c) Copyright Frontify Ltd., all rights reserved. */

use Frontify\ColorApi\ColorEndpoint;
use Sunrise\Http\ServerRequest\ServerRequestFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$request = ServerRequestFactory::fromGlobals();
$endpoint = new ColorEndpoint();

header('Content-Type: application/json');

echo json_encode($endpoint->handle($request), JSON_THROW_ON_ERROR);
