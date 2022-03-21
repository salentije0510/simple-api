<?php

declare(strict_types=1);

namespace Frontify\ColorApi;

use PDO;
use PDOException;

class DbConnection
{
    //Moved away from the singleton approach since having db connection like that prevents further abstractions
    private PDO $connection;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $dbName = getenv('DATABASE_NAME');
        $dsn = sprintf(
            '%s:%s\%s\%s.db',
            getenv('DATABASE_ENGINE'),
            Application::PROJECT_ROOT_PATH,
            getenv('DATABASE_DIR'),
            $dbName,
        );

        try {
            $this->connection = new PDO(
                $dsn,
                !empty(getenv('DATABASE_USER')) ? getenv('DATABASE_USER') : null,
                empty(getenv('DATABASE_PASSWORD')) ? getenv('DATABASE_PASSWORD') : null,
                [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION],
            );

            // Should be done using the migrations but in order to save time it's executed here
            $this->connection->query(
                'CREATE TABLE IF NOT EXISTS colors (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(20) NOT NULL, hex VARCHAR(7) NOT NULL, CONSTRAINT color_unique UNIQUE (name, hex))',
            );

            $this->connection->query(
                'CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(20) NOT NULL, token VARCHAR(100) NOT NULL, CONSTRAINT username_unique UNIQUE (username))',
            );
        } catch (PDOException $e) {
            throw new \Exception(sprintf('Database error: %s', $e->getMessage()));
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
