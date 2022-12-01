<?php

namespace RusinovArtem\Console;

class Input
{
    public function __construct(
        public ArgumentBag $arguments = new ArgumentBag(),
        public ParameterBag $parameters = new ParameterBag(),
        public string $commandName = ""
    ) {
    }

    public static function buildFromGlobals()
    {
        $input = new static;
        $tokenizer = new Tokenizer();
        $input->commandName = $_SERVER['argv'][1] ?? "";
        for ($i = 2; $i < count($_SERVER['argv']); ++$i) {
            $arg = trim($_SERVER['argv'][$i]);
            $tokenizer->run($arg, $input);
        }
        return $input;
    }

    public static function build(string $command, string $args)
    {
        $input = new static;
        $tokenizer = new Tokenizer();
        $input->commandName = $command;
        $tokenizer->run($args, $input);
        return $input;
    }
}