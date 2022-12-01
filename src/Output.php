<?php

namespace RusinovArtem\Console;

class Output
{
    public function out(string $str): int|false
    {
        return fwrite(STDIN, $str);
    }

    public function err(string $str): int|false
    {
        return fwrite(STDERR, $str);
    }
}