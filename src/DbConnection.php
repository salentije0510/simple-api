<?php

declare(strict_types=1);


namespace Frontify\ColorApi;

use PDO;
use PDOException;

class DbConnection
{
    private static ?self $instance = null;

    private PDO $connection;

    /**
     * @throws \Exception
     */
    private function __construct()
    {
        $dbName = getenv('DATABASE_NAME');
        $dsn = sprintf(
            '%s:%s\%s\%s.db',
            getenv('DATABASE_ENGINE'),
            PROJECT_ROOT_PATH,
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

            $this->connection->beginTransaction();
            // Should be done using the migrations but in order to save time it's executed here
            $this->connection->query('CREATE TABLE IF NOT EXISTS color (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,name VARCHAR(20) NOT NULL,hex VARCHAR(7) NOT NULL)');

            $this->connection->query('CREATE TABLE IF NOT EXISTS user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,username VARCHAR(20) NOT NULL,token VARCHAR(100) NOT NULL)');

            $username = 'sasa_p';
            $password = password_hash('Test123!', PASSWORD_DEFAULT);

            $query = $this->connection->prepare('INSERT INTO user(username, token) VALUES (:username, :password)');
            $query->bindParam('username', $username);
            $query->bindParam('password', $password);

            $query->execute();
        } catch (PDOException $e) {

            throw new \Exception(sprintf('Database error: %s', $e->getMessage()));
        }
    }

    /**
     * @throws \Exception
     */
    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __clone()
    {
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}