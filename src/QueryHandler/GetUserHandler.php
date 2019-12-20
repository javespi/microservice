<?php

namespace App\QueryHandler;

use Domain\Model\User;
use App\Query\GetUser;

class GetUserHandler
{
    public function handle(GetUser $query): User
    {
        return new User($query->id(), 'Bob');
    }
}