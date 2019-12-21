<?php

declare(strict_types=1);

namespace App\Middleware;

use League\Tactician\Middleware;

class DummyMiddleware implements Middleware
{
    public function execute($command, callable $next)
    {
        return $next($command);
    }
}
