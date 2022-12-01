<?php

namespace RusinovArtem\Console\Command;

use RusinovArtem\Console\Input;
use RusinovArtem\Console\Output;

class ShowList extends Command
{
    public function run(Input $inp, Output $out): int
    {
        $list = $this->app->getCommands();
        $pad = max(
            array_map(function ($v) {
                return strlen($v);
            }, $list)
        );
        foreach ($this->app->getCommands() as $commandName) {
            $commandNameWithPadding = str_pad($commandName, $pad);
            $out->out("   - $commandNameWithPadding    " . $this->app->getDescriptionOf($commandName) . "\n");
        }
        return 0;
    }

    public static function getDescription(): string
    {
        return "List all commands";
    }

    public static function getHelp(string $entryPoint, string $command): string
    {
        return <<<TEXT
            This command show full list of commands in the App
            usage:
              php {$entryPoint} {$command}
        TEXT;
    }
}