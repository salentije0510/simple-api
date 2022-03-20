<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

const PROJECT_ROOT_PATH = __DIR__ . '/../';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');


(new Frontify\ColorApi\DotEnvLoader(
    sprintf('%s/.env', PROJECT_ROOT_PATH)
))->load();

\Frontify\ColorApi\DbConnection::getInstance();
