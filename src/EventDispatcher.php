<?php

namespace RusinovArtem\Console;

use Psr\EventDispatcher\EventDispatcherInterface;

class EventDispatcher implements EventDispatcherInterface
{
    protected array $listeners;

    public function on(string $event, callable $fn) {
        $this->listeners[$event][] = $fn;
    }

    public function dispatch(object $event)
    {
        if(!array_key_exists($event::class, $this->listeners)) {
            return;
        }

        foreach ($this->listeners[$event::class] as $listener) {
            $listener($event);
        }
    }
}