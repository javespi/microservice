<?php

declare(strict_types=1);

namespace tests\Microservice\Infrastructure\Repository\Doctrine;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Microservice\Domain\User\UserRepository;
use Microservice\Infrastructure\Repository\Doctrine\DoctrineUserRepository;
use tests\Microservice\Domain\User\UserRepositoryTest;

class DoctrineUserRepositoryTest extends UserRepositoryTest
{
    public function getEmptyRepository(): UserRepository
    {
        $connection = DriverManager::getConnection([
            'user' => 'root',
            'password' => 'root',
            'driver' => 'pdo_sqlite',
            'path' => ':memory:',
        ], new Configuration());

        $schemaManager = $connection->getSchemaManager();
        $schema = $schemaManager->createSchema();
        $table = $schema->createTable('users');
        $table->addColumn('id', 'string');
        $table->addColumn('name', 'string');
        $table->setPrimaryKey(['id']);
        $sql = $schema->toSql(
            $connection->getDatabasePlatform()
        );

        foreach ($sql as $query) {
            $connection->executeQuery($query);
        }

        return new DoctrineUserRepository(
            $connection
        );
    }
}
