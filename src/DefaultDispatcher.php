<?php

namespace RusinovArtem\Console;

use Psr\EventDispatcher\EventDispatcherInterface;
use RusinovArtem\Console\Event\CommandReceived;
use RusinovArtem\Console\Example\DebugInputCommand;

class DefaultDispatcher
{
    public static function build(): EventDispatcherInterface
    {
        $dispatcher = new EventDispatcher();

        $dispatcher->on(CommandReceived::class, function (CommandReceived $event) {
            if (empty($event->input->commandName)) {
                $event->input->commandName = 'list';
                $event->input->commandId = $event->app->findCommand('list');
            }
        });

        $dispatcher->on(CommandReceived::class, function (CommandReceived $event) {
            if ($event->input->arguments->has('debug')) {
                $event->input->commandId = DebugInputCommand::class;
            }
        });

        return $dispatcher;
    }
}