<?php

namespace tests\Domain\Model;

use Domain\Exceptions\UserNotFoundException;
use Domain\Model\User;
use Domain\Model\UserRepository;
use PHPUnit\Framework\TestCase;

abstract class UserRepositoryTest extends TestCase
{
    abstract public function getEmptyRepository(): UserRepository;

    public function onEmptyRepositoryThrowsNotFound(): void
    {
        $repository = $this->getEmptyRepository();

        $this->expectException(UserNotFoundException::class);
        $repository->findById('test-id');
    }

    public function onNotEmptyRepositoryReturnsUser(): void
    {
        $repository = $this->getEmptyRepository();
        $repository->save(
            $user = new User('user-id', 'user-name')
        );

        $this->assertEquals(
            $user,
            $repository->findById('user-id')
        );
    }

    public function onNotEmptyRepositoryThrowsNotFound(): void
    {
        $repository = $this->getEmptyRepository();
        $repository->save(
            $user = new User('user-id', 'user-name')
        );

        $this->expectException(UserNotFoundException::class);
        $repository->findById('not-found-user-id');
    }


    public function onSaveUserRepositoryReturnsModifiedUser(): void
    {
        $repository = $this->getEmptyRepository();
        $repository->save(
            new User('user-id-alice', 'user-name')
        );
        $repository->save(
            new User('user-id-bob', 'user-name-bob')
        );
        $repository->save(
            new User('user-id-bob', 'user-name-bob')
        );

        $this->assertEquals(
            new User('user-id-bob', 'user-name-bob'),
            $repository->findById('user-id-bob')
        );
    }
}
