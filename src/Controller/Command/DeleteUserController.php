<?php

declare(strict_types=1);

namespace App\Controller\Command;

use App\Command\DeleteUser;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteUserController
{
    /* @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        $this->commandBus->handle(
            new DeleteUser(
                $request->get('id')
            )
        );

        return new JsonResponse(null, 204);
    }
}
