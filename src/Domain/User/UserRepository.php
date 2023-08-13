<?php

declare(strict_types=1);

namespace App\Domain\User;

interface UserRepository
{
    /**
     * @param int $id
     * @return User[]
     */
    public function findAll(int $id): array;

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): User;

    /**
     * @param string $name
     * @param string $password
     * @param string $last_seen_at
     * @return User
     * @throws UserNotFoundException
     */
    public function createUser(
        string $name,
        string $password,
        string $last_seen_at
    ): User;
}
