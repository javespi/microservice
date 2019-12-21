<?php

declare(strict_types=1);

namespace Domain\Model;

use Domain\Exceptions\UserNotFoundException;

class InMemoryUserRepository implements UserRepository
{
    /** @var User[] */
    private $memory = [];

    /**
     * @throws UserNotFoundException
     */
    public function findById(string $id): User
    {
        if (false === isset($this->memory[$id])) {
            throw new UserNotFoundException();
        }

        return $this->memory[$id];
    }

    public function save(User $user): void
    {
        $this->memory[$user->id()] = $user;
    }

    public function delete(string $id): void
    {
        unset($this->memory[$id]);
    }
}
