<?php

namespace RusinovArtem\Console;

use RusinovArtem\Console\Exception\InputFormat;

class Tokenizer
{
    public function run(string $str, Input $inp): void
    {
        $len = strlen($str);

        for ($i = 0; $i < $len; ++$i) {
            if ('{' == $str[$i]) {
                $end = strpos($str, '}', $i);
                if (!$end) {
                    throw new InputFormat("Expected } after position $i ");
                }
                $this->fetchArgs(substr($str, $i + 1, $end - 1 - $i), $inp);
                $i += $end;
            } else {
                if ('[' == $str[$i]) {
                    $end = strpos($str, ']', $i);
                    if (!$end) {
                        throw new InputFormat("Expected ] after position $i");
                    }
                    $this->fetchParameter(substr($str, $i + 1, $end - 1 - $i), $inp, $i);
                    $i += $end;
                }
            }
        }
    }

    protected function fetchArgs(string $substr, Input $inp): void
    {
        $args = explode(",", $substr);
        foreach ($args as $arg) {
            $arg = trim($arg);
            if (!empty($arg)) {
                $inp->arguments->add($arg);
            }
        }
    }

    protected function fetchParameter(string $substr, Input $inp, int $pos): void
    {
        $eqPosition = strpos($substr, '=');
        if (false === $eqPosition) {
            throw new InputFormat("Expected = after position $pos");
        }
        $exp = explode('=', $substr);
        if (count($exp) < 2) {
            throw new InputFormat("Unable to parse parameter on position $pos");
        }
        $parameterName = trim($exp[0]);
        $value = trim($exp[1]);
        if (!empty($value) && '{' == $value[0]) {
            $end = strpos($value, '}');
            if (false === $end) {
                throw new InputFormat("Expected } after position $pos");
            }
            $values = $this->fetchMultiValue(substr($value, 1, $end - 1));
            $values = array_map(trim(...), $values);
            $inp->parameters->add($parameterName, $values);
        } else {
            $inp->parameters->add($parameterName, $value);
        }
    }

    protected function fetchMultiValue(string $substr): array
    {
        return explode(',', $substr);
    }
}