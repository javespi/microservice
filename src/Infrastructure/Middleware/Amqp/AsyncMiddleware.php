<?php

declare(strict_types=1);

namespace Microservice\Infrastructure\Middleware\Amqp;

use League\Tactician\Middleware;
use Microservice\Application\Command\AsyncCommand;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class AsyncMiddleware implements Middleware
{
    /** @var AMQPChannel */
    private $channel;

    public function __construct(AMQPChannel $channel)
    {
        $this->channel = $channel;
    }

    public function execute($command, callable $next): void
    {
        if ($command instanceof AsyncCommand) {
            $this->channel->basic_publish(
                new AMQPMessage(
                    serialize($command), [
                        'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
                    ]
                ),
                '',
                'commands'
            );

            return;
        }

        $next($command);
    }
}
