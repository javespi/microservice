<?php

declare(strict_types=1);

namespace tests\Domain\Model;

use Domain\Model\InMemoryUserRepository;
use Domain\Model\UserRepository;

class InMemoryUserRepositoryTest extends UserRepositoryTest
{
    public function getEmptyRepository(): UserRepository
    {
        return new InMemoryUserRepository();
    }
}
