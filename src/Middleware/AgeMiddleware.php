<?php

namespace App\Middleware;

use App\Query\GetUser;
use League\Tactician\Middleware;

class AgeMiddleware implements Middleware
{
    public function execute($command, callable $next)
    {
        $result = $next($command);

        if ($command instanceof GetUser) {
            $result->attr['age'] = 20;
        }

        return $result;
    }
}