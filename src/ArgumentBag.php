<?php

namespace RusinovArtem\Console;

class ArgumentBag
{
    private array $bag = [];

    public function add($name)
    {
        $this->bag[$name] = true;
    }

    public function has($name): bool
    {
        return array_key_exists($name, $this->bag);
    }

    public function getList(): array
    {
        return array_keys($this->bag);
    }

}