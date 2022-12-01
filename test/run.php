<?php

use RusinovArtem\Console\BuildInput;
use RusinovArtem\Console\Input;

require_once __DIR__ . "/../vendor/autoload.php";

$inp = BuildInput::fromGlobals();
echo $inp->commandName . "\n";
echo "Arguments: \n";
echo json_encode($inp->arguments->getList()) . "\n";
echo "Params: \n";
echo json_encode($inp->parameters->toArray()) . "\n";
