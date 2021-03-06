<?php

declare(strict_types=1);

namespace Microservice\Application\CommandHandler;

use Microservice\Application\Command\DeleteUser;
use Microservice\Domain\User\UserRepository;

class DeleteUserHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(DeleteUser $query): void
    {
        $this->userRepository->delete(
            $query->id()
        );
    }
}
