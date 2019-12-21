<?php

declare(strict_types=1);

namespace App\CommandHandler;

use App\Command\SaveUser;
use Domain\Model\User;
use Domain\Model\UserRepository;

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
