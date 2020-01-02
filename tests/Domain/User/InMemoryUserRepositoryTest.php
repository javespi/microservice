<?php

declare(strict_types=1);

namespace tests\Microservice\Domain\User;

use Microservice\Domain\User\InMemoryUserRepository;
use Microservice\Domain\User\UserRepository;

class InMemoryUserRepositoryTest extends UserRepositoryTest
{
    public function getEmptyRepository(): UserRepository
    {
        return new InMemoryUserRepository();
    }
}
