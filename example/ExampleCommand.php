<?php

namespace RusinovArtem\Console\Example;

use RusinovArtem\Console\Command\Command;
use RusinovArtem\Console\Input;
use RusinovArtem\Console\Output;

class ExampleCommand extends Command
{
    public function run(Input $inp, Output $out): int
    {
        if ($inp->parameters->has('name')) {
            $name = $inp->parameters->first('name');
            $out->out("Hello, $name!\n");
        } else {
            $out->out("Hello!\n");
        }

        return 0;
    }

    public static function getHelp(string $entryPoint, string $command): string
    {
        return <<<TEXT
                    This command not just prints hello. It can say hello
                    to a specific person if you pass it a name!
                    usage:
                        php {$entryPoint} {$command} [name=Artem] 
                        php {$entryPoint} {$command} hello 
              TEXT;
    }
}