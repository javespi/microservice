<?php

declare(strict_types=1);

namespace Microservice\Infrastructure\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Microservice\Domain\User\User;
use Microservice\Domain\User\UserNotFoundException;
use Microservice\Domain\User\UserRepository;

final class DoctrineUserRepository implements UserRepository
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findById(string $id): User
    {
        $data = $this
            ->connection
            ->createQueryBuilder()
            ->select('u.name as name')
            ->from('users', 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->execute()
            ->fetchAll();

        if (empty($data)) {
            throw new UserNotFoundException();
        }

        return new User($id, $data[0]['name']);
    }

    public function save(User $user): void
    {
        try {
            $this->findById($user->id());
            $this->connection
                ->createQueryBuilder()
                ->update('users')
                ->set('name', ':name')
                ->where('id = :id')
                ->setParameters([
                    'id' => $user->id(),
                    'name' => $user->name(),
                ])
                ->execute();
        } catch (UserNotFoundException $exception) {
            $this->connection
                ->createQueryBuilder()
                ->insert('users')
                ->values([
                    'id' => '?',
                    'name' => '?',
                ])
                ->setParameters([
                    $user->id(),
                    $user->name(),
                ])
                ->execute();
        }
    }

    public function delete(string $id): void
    {
        $this
            ->connection
            ->createQueryBuilder()
            ->delete('users')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->execute();
    }
}
