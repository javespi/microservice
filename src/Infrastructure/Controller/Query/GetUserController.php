<?php

declare(strict_types=1);

namespace Microservice\Infrastructure\Controller\Query;

use App\Query\GetUser;
use League\Tactician\CommandBus;
use Microservice\Domain\User\UserNotFoundException;
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
        try {
            $user = $this->commandBus->handle(
                new GetUser(
                    $request->get('id')
                )
            );
        } catch (UserNotFoundException $exception) {
            return new Response(null, 404);
        }

        return new JsonResponse([
            'id' => $user->id(),
            'name' => $user->name(),
        ]);
    }
}
