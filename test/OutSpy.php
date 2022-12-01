<?php

namespace RusinovArtem\Console\Test;

use RusinovArtem\Console\Output;

class OutSpy extends Output
{
    public string $stdout = "";
    public string $stderr = "";

    public function out(string $str): int|false
    {
        $len = strlen($str);
        $this->stdout .= $str;
        return $len;
    }

    public function err(string $str): int|false
    {
        $len = strlen($str);
        $this->stderr .= $str;
        return $len;
    }
}