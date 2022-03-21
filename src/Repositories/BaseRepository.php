<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Repositories;

use Frontify\ColorApi\DbConnection;
use PDO;

class BaseRepository
{
    protected PDO $connection;

    public function __construct(DbConnection $db)
    {
        $this->connection = $db->getConnection();
    }
}
