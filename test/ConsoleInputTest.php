<?php

use PHPUnit\Framework\TestCase;

class ConsoleInputTest extends TestCase
{

    public function test_CanFetchCommandName()
    {
        $commandName = "commandName";
        exec("php " . __DIR__ . "/run.php commandName", $out);
        self::assertEquals($commandName, $out[0]);
    }

    public function test_CanRecognizeSingleArg()
    {
        exec("php " . __DIR__ . "/run.php commandName {arg1}", $out);
        self::assertEquals(json_encode(['arg1']), $out[2]);
    }

    public function test_CanRecognizeSingleDoubleArg()
    {
        exec("php " . __DIR__ . "/run.php commandName {arg1,arg2}", $out);
        self::assertEquals(json_encode(['arg1', 'arg2']), $out[2]);
    }

    public function test_CanRecognizeSmashedArgs()
    {
        exec("php " . __DIR__ . "/run.php commandName {arg1}{arg2}", $out);
        self::assertEquals(json_encode(['arg1', 'arg2']), $out[2]);
    }

    public function test_CanRecognizeParameter()
    {
        exec("php " . __DIR__ . "/run.php commandName [p1=Value]", $out);
        self::assertEquals(json_encode(['p1' => ['Value']]), $out[4]);
    }

    public function test_CanRecognizeMultivalueParameter()
    {
        exec("php " . __DIR__ . "/run.php commandName [p1={Value}]", $out);
        self::assertEquals(json_encode(['p1' => ['Value']]), $out[4]);
    }
}