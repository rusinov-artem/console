<?php

use RusinovArtem\Console\App;
use RusinovArtem\Console\BuildInput;
use RusinovArtem\Console\Output;

require_once __DIR__ . "/../vendor/autoload.php";

return (new App(include __DIR__ . "/map.php"))->run(BuildInput::fromGlobals(), new Output());