<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Entities;

interface EntityInterface
{
    public function getId(): int;

    /**
     * @return array<string, mixed>
     */
    public function toAssocArray(): array;
}
