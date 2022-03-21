<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Repositories;

use Frontify\ColorApi\DbConnection;
use Frontify\ColorApi\Entities\EntityInterface;
use Frontify\ColorApi\Entities\UserEntity;

class UserRepository extends BaseRepository implements EntityRepositoryInterface
{
    public function find(int $id): ?EntityInterface
    {
        // TODO: Implement find() method.
    }

    /**
     * @inheritDoc
     */
    public function findBy(array $filters): array
    {
        // For now we search only by username
        try {
            $query = $this->connection->prepare('SELECT * FROM users WHERE username=:username');
            $query->bindParam('username', $filters['username']);
            $query->execute();
            $queryResult = $query->fetch();
        } catch (\PDOException $e) {
            throw new \Exception(sprintf('Database error: %s', $e->getMessage()));
        }

        return [new UserEntity((int) $queryResult['id'], $queryResult['username'], $queryResult['token'])];
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        // TODO: Implement findAll() method.
    }

    public function save(EntityInterface $entity): EntityInterface
    {
        // TODO: Implement save() method.
    }

    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
    }

    public function update(EntityInterface $entity): void
    {
        // TODO: Implement update() method.
    }
}
