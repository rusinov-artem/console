<?php

use RusinovArtem\Console\App;
use RusinovArtem\Console\Input;
use RusinovArtem\Console\Output;

require_once __DIR__ . "/../vendor/autoload.php";

return (new App(include __DIR__ . "/map.php"))->run(Input::buildFromGlobals(), new Output());