<?php

namespace RusinovArtem\Console\Event;

use RusinovArtem\Console\App;
use RusinovArtem\Console\Input;
use RusinovArtem\Console\Output;

class CommandReceived
{
    public function __construct(
        public App $app,
        public Input $input,
        public Output $output,
    )
    {
    }
}