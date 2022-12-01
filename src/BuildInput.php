<?php

namespace RusinovArtem\Console;

class BuildInput
{
    public static function fromGlobals(): Input
    {
        $input = new Input();
        $tokenizer = new Tokenizer();
        $input->entryPoint = $_SERVER['argv'][0];
        $input->raw = $_SERVER['argv'];
        $input->commandName = $_SERVER['argv'][1] ?? "";
        for ($i = 2; $i < count($_SERVER['argv']); ++$i) {
            $option = trim($_SERVER['argv'][$i]);
            $tokenizer->run($option, $input);
        }
        return $input;
    }

    public static function from(string $command, string $options, string $entryPoint = "./run")
    {
        $input = new Input;
        $input->entryPoint = $entryPoint;
        $input->commandName = $command;
        $input->raw = [$entryPoint, $options];
        $tokenizer = new Tokenizer();
        $options = trim($options);
        $tokenizer->run($options, $input);
        return $input;
    }
}