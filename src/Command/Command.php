<?php

namespace RusinovArtem\Console\Command;

use RusinovArtem\Console\App;
use RusinovArtem\Console\Input;
use RusinovArtem\Console\Output;

class Command
{
    protected App $app;

    public function setApp(App $app)
    {
        $this->app = $app;
    }

    public static function getDescription(): string
    {
        return "There should be short description";
    }

    public static function getHelp(Input $inp): string
    {
        return "There should be detailed help for command `php {$inp->entryPoint} {$inp->commandName}`";
    }

    public function run(Input $inp, Output $out): int
    {
        return 0;
    }
}