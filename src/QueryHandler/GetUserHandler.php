<?php

declare(strict_types=1);

namespace App\QueryHandler;

use App\Query\GetUser;
use Domain\Model\User;
use Domain\Model\UserRepository;

class GetUserHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(GetUser $query): User
    {
        return $this->userRepository->findById(
            $query->id()
        );
    }
}
