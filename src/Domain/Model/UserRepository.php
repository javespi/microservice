<?php

declare(strict_types=1);

namespace Domain\Model;

use Domain\Exceptions\UserNotFoundException;

interface UserRepository
{
    /**
     * @throws UserNotFoundException
     */
    public function findById(string $id): User;

    public function save(User $user): void;

    public function delete(string $id): void;
}
