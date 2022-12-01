<?php

namespace RusinovArtem\Console;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use RusinovArtem\Console\Command\Command;
use RusinovArtem\Console\Event\AfterExecution;
use RusinovArtem\Console\Event\BeforeExecution;

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
        if (empty($inp->commandName)) {
            $inp->commandName = "default";
        }

        $commandId = $this->findCommand($inp->commandName);

        if ($inp->arguments->has('help')) {
            $out->out($this->getHelpFor($inp->commandName) . "\n");
            return 0;
        }

        if (is_null($commandId)) {
            $out->err("Command {$inp->commandName} not found\n");
            return 1;
        }

        $command = $this->build($commandId);

        $this->dispatch(new BeforeExecution($command, $inp, $out));
        $result = $command->run($inp, $out);
        $this->dispatch(new AfterExecution($command, $inp, $out, $result));
        return $result;
    }

    public function getHelpFor($commandName): string
    {
        return $this->map[$commandName]::getHelp();
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

    protected function build($commandId): Command
    {
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

    protected function findCommand(string $commandName): mixed
    {
        return $this->map[$commandName] ?? null;
    }
}