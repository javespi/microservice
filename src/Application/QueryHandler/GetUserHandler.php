<?php

declare(strict_types=1);

namespace Microservice\Application\QueryHandler;

use Microservice\Application\Query\GetUser;
use Microservice\Domain\User\User;
use Microservice\Domain\User\UserRepository;

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
