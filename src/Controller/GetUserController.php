<?php

declare(strict_types=1);

namespace App\Controller;

use App\Query\GetUser;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetUserController
{
    /* @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        $user = $this->commandBus->handle(
            new GetUser(
                $request->get('id')
            )
        );

        return new JsonResponse([
            'id' => $user->id(),
            'name' => $user->name(),
            'att' => $user->attr,
        ]);
    }
}
