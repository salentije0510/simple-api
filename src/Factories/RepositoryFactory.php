<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Factories;

use Frontify\ColorApi\Controllers\ColorController;
use Frontify\ColorApi\DbConnection;
use Frontify\ColorApi\Repositories\BaseRepository;
use Frontify\ColorApi\Repositories\ColorRepository;

class RepositoryFactory
{
    public static function make(string $controllerClass): ?BaseRepository
    {
        return match ($controllerClass) {
            ColorController::class => new ColorRepository(DbConnection::getInstance()),
            default => null
        };
    }
}
