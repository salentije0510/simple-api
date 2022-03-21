<?php

declare(strict_types=1);

namespace Frontify\ColorApi;

use Frontify\ColorApi\Entities\UserEntity;
use Frontify\ColorApi\Repositories\UserRepository;

class Auth
{
    public static function user(string $username, string $token): ?UserEntity
    {
        $userRepository = new UserRepository(new DbConnection());
        try {
            $users = $userRepository->findBy(['username' => $username]);
        } catch (\Exception $e) {
            return null;
        }

        return $users[0]->tokenMatch($token) ? $users[0] : null;
    }
}
