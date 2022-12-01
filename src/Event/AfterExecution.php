<?php

namespace RusinovArtem\Console\Event;

use RusinovArtem\Console\Command\Command;
use RusinovArtem\Console\Input;
use RusinovArtem\Console\Output;

class AfterExecution
{
    public function __construct(
        public Command $command,
        public Input $in,
        public Output $out
    ) {
    }
}