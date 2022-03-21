<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Repositories;

use Frontify\ColorApi\Entities\EntityInterface;

interface EntityRepositoryInterface
{
    public function find(int $id): ?EntityInterface;

    /**
     * @return array<EntityInterface>
     */
    public function findBy(array $filters): array;

    /**
     * @return array<int, EntityInterface>
     */
    public function findAll(): array;

    public function save(EntityInterface $entity): EntityInterface;

    public function delete(int $id): void;

    public function update(EntityInterface $entity): void;
}
