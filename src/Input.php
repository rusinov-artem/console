<?php

namespace RusinovArtem\Console;

class Input
{
    public function __construct(
        public ArgumentBag $arguments = new ArgumentBag(),
        public ParameterBag $parameters = new ParameterBag(),
        public array $raw = [],
        public string $commandName = "",
        public string $entryPoint = ""
    ) {
    }
}