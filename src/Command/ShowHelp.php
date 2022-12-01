<?php

namespace RusinovArtem\Console\Command;

use RusinovArtem\Console\Input;
use RusinovArtem\Console\Output;

class ShowHelp extends Command
{
    protected string $command = '';

    public function run(Input $inp, Output $out): int
    {
        $this->printHead($inp, $out);
        $out->out($this->app->getHelpFor($inp) . "\n");
        return 0;
    }

    public function for(string $command): static
    {
        $this->command = $command;
        return $this;
    }

    public function getCommand() {
        if(!empty($this->command)) return $this->command;
        return 'help';
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
                php $inp->entryPoint $inp->commandName {commandName}
                
        TEXT;
    }

    protected function printHead(Input $inp, Output $out)
    {
        $command = $this->getCommand();
        $out->out("Help for command {$command}: \n");
    }
}