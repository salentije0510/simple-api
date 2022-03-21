<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Entities;

class ColorEntity implements EntityInterface
{
    public function __construct(private string $name, private string $hex, private ?int $id = null)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHex(): string
    {
        return $this->hex;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function toAssocArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'hex' => $this->hex,
        ];
    }
}
