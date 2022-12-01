<?php

namespace RusinovArtem\Console;

use RusinovArtem\Console\Exception\MissedParameter;

class ParameterBag
{
    private array $bag = [];

    public function add(string $name, string|array $value): void
    {
        if (!is_array($value)) {
            $this->bag[$name] = array_merge($this->bag[$name] ?? [], [$value]);
        } else {
            $this->bag[$name] = array_merge($this->bag[$name] ?? [], $value);
        }
    }

    public function getList(): array
    {
        return array_keys($this->bag);
    }

    public function has($name): bool {
        return array_key_exists($name, $this->bag);
    }

    public function first($name): string
    {
        if (!isset($this->bag[$name][0])) {
            throw new MissedParameter($name);
        }
        return $this->bag[$name][0];
    }

    public function get($name): array
    {
        if (!isset($this->bag[$name])) {
            throw new MissedParameter($name);
        }
        return $this->bag[$name];
    }

    public function toArray() {
        return $this->bag;
    }

}