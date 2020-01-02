<?php

declare(strict_types=1);

namespace Microservice\Infrastructure\Controller\Command;

use App\Command\SaveUser;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SaveUserController
{
    /* @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);

        $this->commandBus->handle(
            new SaveUser(
                $request->get('id'),
                $content['name']
            )
        );

        return new Response(null);
    }
}
