<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Entity;

interface EntityInterface
{
    public function getId(): int;

    /**
     * @return array<string, mixed>
     */
    public function toAssocArray(): array;
}
