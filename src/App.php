<?php

namespace RusinovArtem\Console;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use RusinovArtem\Console\Command\Command;
use RusinovArtem\Console\Event\AfterExecution;
use RusinovArtem\Console\Event\BeforeExecution;
use RusinovArtem\Console\Event\CommandReceived;

class App
{
    protected ?ContainerInterface $container = null;
    protected ?EventDispatcherInterface $eventDispatcher = null;

    public function __construct(
        protected array $map
    ) {
    }

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function run(Input $inp, Output $out): int
    {
        $inp->commandId = $this->findCommand($inp->commandName);
        $this->dispatch(new CommandReceived($this, $inp, $out));

        if (is_null($inp->commandId)) {
            $out->err("Command $inp->commandName not found\n");
            return 1;
        }

        $command = $this->build($inp->commandId);

        $this->dispatch(new BeforeExecution($command, $inp, $out));
        $result = $command->run($inp, $out);
        $this->dispatch(new AfterExecution($command, $inp, $out));
        return $result;
    }

    public function getHelpFor(string $commandName, string $entryPoint): string
    {
        return $this->map[$commandName]::getHelp($commandName, $entryPoint);
    }

    public function getDescriptionOf($commandName): string
    {
        return $this->map[$commandName]::getDescription();
    }

    /**
     * @return string[]
     */
    public function getCommands(): array
    {
        return array_keys($this->map);
    }

    public function build($commandId): Command
    {
        if($commandId instanceof Command) {
            return $commandId;
        }

        if ($this->container) {
            if ($this->container->has($commandId)) {
                return $this->container->get($commandId);
            }
        }

        $command = new $commandId();
        $command->setApp($this);
        return $command;
    }

    protected function dispatch(object $event): void
    {
        $this->eventDispatcher?->dispatch($event);
    }

    public function findCommand(string $commandName): mixed
    {
        return $this->map[$commandName] ?? null;
    }
}