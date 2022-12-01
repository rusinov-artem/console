<?php

namespace RusinovArtem\Console;

use Psr\EventDispatcher\EventDispatcherInterface;
use RusinovArtem\Console\Command\ShowHelp;
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
            if ($event->input->arguments->has('help')) {
                /** @var ShowHelp $helpCommand */
                $helpCommand = $event->app->build(ShowHelp::class);
                $helpCommand->for($event->input->commandName);
                $event->input->commandId = $helpCommand;
            }
        });

        $dispatcher->on(CommandReceived::class, function (CommandReceived $event) {
            if ('help' == $event->input->commandName) {
                /** @var ShowHelp $helpCommand */
                $helpCommand = $event->app->build(ShowHelp::class);
                $helpCommand->for($event->input->arguments->getList()[0]??'help');
                $event->input->commandId = $helpCommand;
            }
        });

        return $dispatcher;
    }
}