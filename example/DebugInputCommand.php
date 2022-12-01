<?php

namespace RusinovArtem\Console\Example;

use RusinovArtem\Console\Command\Command;
use RusinovArtem\Console\Input;
use RusinovArtem\Console\Output;

class DebugInputCommand extends Command
{
    public function run(Input $inp, Output $out): int
    {
        $out->out("Called command: {$inp->commandName}\n");
        $this->showArguments($inp, $out);
        $this->showParameters($inp, $out);
        return 0;
    }

    protected function showArguments(Input $inp, Output $out)
    {
        $out->out("Arguments:\n");
        $list = $inp->arguments->getList();
        if(empty($list)) {
            $out->out("  No arguments passed\n\n");
            return;
        }

        foreach ($list as $argument) {
            $out->out("  -  $argument\n");
        }
    }

    public static function getDescription(): string
    {
        return "Show arguments and options passed";
    }

    public static function getHelp(): string
    {
       return <<<TEXT
                This command shows passed arguments and options
                usage:
                    ./run debug:input {arg1} [name=Artem]
            TEXT;

    }

    protected function showParameters(Input $inp, Output $out)
    {
        $out->out("Options:\n");
        $list = $inp->parameters->toArray();
        if(empty($list)) {
            $out->out("  No options passed\n\n");
            return;
        }

        foreach ($list as $option=>$values) {
            $out->out("  -  $option:\n");
            foreach ($values as $value) {
                $out->out("    -  $value\n");
            }
        }
    }
}