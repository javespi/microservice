<?php

declare(strict_types=1);

namespace Microservice\Application\CommandHandler;

use Microservice\Application\Command\SaveUser;
use Microservice\Domain\User\User;
use Microservice\Domain\User\UserRepository;

class SaveUserHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(SaveUser $query): void
    {
        $this->userRepository->save(
            new User(
                $query->id(),
                $query->name()
            )
        );
    }
}
