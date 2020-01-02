<?php

declare(strict_types=1);

namespace tests\Microservice\Domain\User;

use Microservice\Domain\User\User;
use Microservice\Domain\User\UserNotFoundException;
use Microservice\Domain\User\UserRepository;
use PHPUnit\Framework\TestCase;

abstract class UserRepositoryTest extends TestCase
{
    abstract public function getEmptyRepository(): UserRepository;

    /**
     * @test
     */
    public function onEmptyRepositoryThrowsNotFound(): void
    {
        $repository = $this->getEmptyRepository();

        $this->expectException(UserNotFoundException::class);
        $repository->findById('test-id');
    }

    /**
     * @test
     */
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

    /**
     * @test
     */
    public function onNotEmptyRepositoryThrowsNotFound(): void
    {
        $repository = $this->getEmptyRepository();
        $repository->save(
            $user = new User('user-id', 'user-name')
        );

        $this->expectException(UserNotFoundException::class);
        $repository->findById('not-found-user-id');
    }

    /**
     * @test
     */
    public function onSaveUserRepositoryReturnsModifiedUser(): void
    {
        $repository = $this->getEmptyRepository();
        $repository->save(
            new User('user-id-alice', 'user-name')
        );
        $repository->save(
            new User('user-id-bob', 'user-name-bb')
        );
        $repository->save(
            new User('user-id-bob', 'user-name-bob')
        );

        $this->assertEquals(
            new User('user-id-bob', 'user-name-bob'),
            $repository->findById('user-id-bob')
        );
    }

    /**
     * @test
     */
    public function onDeleteAfterSaveUserRepositoryThrowsNotFound(): void
    {
        $repository = $this->getEmptyRepository();
        $repository->save(
            $user = new User('user-id', 'user-name')
        );

        $repository->delete('user-id');

        $this->expectException(UserNotFoundException::class);
        $repository->findById('user-id');
    }

    /**
     * @test
     */
    public function onDeleteEmptyRepositoryThrowsNotFound(): void
    {
        $repository = $this->getEmptyRepository();

        $repository->delete('test-id');

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function onDeleteAfterSaveUsersRepositoryReturnsUser(): void
    {
        $repository = $this->getEmptyRepository();
        $repository->save(
            new User('user-alice', 'user-name-alice')
        );
        $repository->save(
            $bob = new User('user-bob', 'user-name-bob')
        );

        $repository->delete('user-alice');

        $this->assertEquals(
            $bob,
            $repository->findById('user-bob')
        );
    }
}
