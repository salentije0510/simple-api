<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Entities;

class UserEntity implements EntityInterface
{
    public function __construct(private int $id, private string $username, private ?string $token = null)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function tokenMatch(string $token): bool
    {
        return password_verify($token, $this->token);
    }

    public function toAssocArray(): array
    {
        return ['id' => $this->id, 'username' => $this->username];
    }
}
