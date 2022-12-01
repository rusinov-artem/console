<?php

namespace RusinovArtem\Console\Command;

use RusinovArtem\Console\Input;
use RusinovArtem\Console\Output;

class ShowHelp extends Command
{
    public function run(Input $inp, Output $out): int
    {
        $out->out("Help for command {$inp->commandName}: \n");
        $out->out($this->app->getHelpFor($inp) . "\n");
        return 0;
    }

    public static function getDescription(): string
    {
        return "Show help for a command";
    }

    public static function getHelp(Input $inp): string
    {
        return <<<TEXT
            This command will show you usage of specified command
            usage:
                ./run help {commandName}
                
        TEXT;
    }
}