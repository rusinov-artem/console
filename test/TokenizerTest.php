<?php

use PHPUnit\Framework\TestCase;
use RusinovArtem\Console\Input;
use RusinovArtem\Console\Tokenizer;

class TokenizerTest extends TestCase
{
    public Tokenizer $tokenizer;
    public Input $input;

    public function setUp(): void
    {
        parent::setUp();
        $this->tokenizer = new Tokenizer();
        $this->input = new Input();
    }

    public static function validArguments()
    {
        return [
            ['{arg1}', ['arg1']],
            ['{arg1,arg2}', ['arg1', 'arg2']],
            ['{arg1}{arg2}', ['arg1', 'arg2']],
            ['{arg1} {arg2}', ['arg1', 'arg2']],
            ['{arg1} { arg2 }', ['arg1', 'arg2']],
        ];
    }

    /** @dataProvider validArguments */
    public function test_ValidArgs($argString, $expected)
    {
        $this->tokenizer->run($argString, $this->input);
        self::assertEquals($expected, $this->input->arguments->getList());
    }

    public static function validParameters()
    {
        return [
            ['[p1=]', ['p1' => ['']]],
            ['[p1={Value}]', ['p1' => ['Value']]],
            ['[p1={Value1,Value2}]', ['p1' => ['Value1', 'Value2']]],
            ['[p1={Value1,Value2}][p2={Value3,Value4}]', ['p1' => ['Value1', 'Value2'], 'p2' => ['Value3', 'Value4']]],
            ['[p1={Value1,Value2}] [p1={Value3,Value4}]', ['p1' => ['Value1', 'Value2', 'Value3', 'Value4']]],
            [
                '[p1 = {Value1, Value2}] [  p1={ Value3 , Value4 }  ]',
                ['p1' => ['Value1', 'Value2', 'Value3', 'Value4']]
            ],
        ];
    }

    /** @dataProvider validParameters */
    public function test_ValidParams($argString, $expected)
    {
        $this->tokenizer->run($argString, $this->input);
        self::assertEquals($expected, $this->input->parameters->toArray());
    }

    public static function validMix()
    {
        return [
            ["", [], []],
            ["{arg1}[p1=v1]", ['arg1'], ['p1' => ['v1']]],
            ["[p1=v1]{arg1}", ['arg1'], ['p1' => ['v1']]],
            ["[p1=v1] {arg1}", ['arg1'], ['p1' => ['v1']]],
            ["[ p1 =  v1 ] { arg1  }", ['arg1'], ['p1' => ['v1']]],
        ];
    }

    /** @dataProvider validMix */
    public function test_ValidMix($argString, $arguments, $parameters)
    {
        $this->tokenizer->run($argString, $this->input);
        self::assertEquals($arguments, $this->input->arguments->getList());
        self::assertEquals($parameters, $this->input->parameters->toArray());
    }

}