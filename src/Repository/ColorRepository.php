<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Repository;

use Frontify\ColorApi\Entity\ColorEntity;
use Frontify\ColorApi\Entity\EntityInterface;

class ColorRepository extends BaseRepository implements EntityRepositoryInterface
{
    /**
     * @throws \Exception
     */
    public function find(int $id): ?ColorEntity
    {
        try {
            $query = $this->connection->prepare('SELECT * FROM colors WHERE id = :entityId');
            $query->bindParam('entityId', $id, \PDO::PARAM_INT);
            $query->execute();
            $queryResult = $query->fetch();
        } catch (\PDOException $e) {
            throw new \Exception(sprintf('Database error: %s', $e->getMessage()));
        }

        return $queryResult
            ? new ColorEntity($queryResult['name'], $queryResult['hex'], (int) $queryResult['id'])
            : null;
    }

    public function findBy(?array $filters): array
    {
        return [];
        // TODO: apply filters to the query
    }

    /**
     * @throws \Exception
     */
    public function save(EntityInterface $entity): EntityInterface
    {
        $name = $entity->getName();
        $hex = $entity->getHex();

        try {
            $query = $this->connection->prepare('INSERT INTO colors(name, hex) VALUES(:name,:hex)');
            $query->bindParam('name', $name);
            $query->bindParam('hex', $hex);
            $query->execute();
            $id = $this->connection->lastInsertId();
        } catch (\PDOException $e) {
            throw new \Exception(sprintf('Database error: %s', $e->getMessage()));
        }

        return new ColorEntity($entity->getName(), $entity->getHex(), $id ? (int) $id : null);
    }

    /**
     * @throws \Exception
     */
    public function delete(int $id): void
    {
        try {
            $query = $this->connection->prepare('DELETE FROM colors WHERE id=:entityId');
            $query->bindParam('entityId', $id);
            $query->execute();
        } catch (\PDOException $e) {
            throw new \Exception(sprintf('Database error: %s', $e->getMessage()));
        }
    }

    /**
     * @throws \Exception
     */
    public function update(EntityInterface $entity): void
    {
        $name = $entity->getName();
        $hex = $entity->getHex();
        $id = $entity->getId();

        try {
            $query = $this->connection->prepare('UPDATE colors SET name=:name, hex=:hex WHERE id=:entityId');
            $query->bindParam('name', $name);
            $query->bindParam('hex', $hex);
            $query->bindParam('entityId', $id);
            $query->execute();
        } catch (\PDOException $e) {
            throw new \Exception(sprintf('Database error: %s', $e->getMessage()));
        }
    }

    /**
     * @throws \Exception
     */
    public function findAll(): array
    {
        try {
            $queryResult = $this->connection->query('SELECT * FROM colors')->fetchAll();
        } catch (\PDOException $e) {
            throw new \Exception(sprintf('Database error: %s', $e->getMessage()));
        }

        return array_map(
            static fn(array $row) => new ColorEntity($row['name'], $row['hex'], (int) $row['id']),
            $queryResult,
        );
    }
}
