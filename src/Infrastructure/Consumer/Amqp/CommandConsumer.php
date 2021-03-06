<?php

declare(strict_types=1);

namespace Microservice\Infrastructure\Consumer\Amqp;

use League\Tactician\CommandBus;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommandConsumer extends Command
{
    /** @var AMQPChannel */
    private $channel;

    /** @var CommandBus */
    private $commandBus;

    public function __construct(AMQPChannel $channel, CommandBus $commandBus)
    {
        parent::__construct('command_consumer');
        $this->channel = $channel;
        $this->commandBus = $commandBus;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->channel->queue_declare('commands', false, true);
        $this->channel->basic_qos(0, 1, false);
        $this->channel->basic_consume(
            'commands',
            '',
            false,
            true,
            false,
            false,
            function (AMQPMessage $message): void {
                $this->commandBus->handle(
                    unserialize($message->getBody())
                );
            }
        );

        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
}
