<?php

use PHPUnit\Framework\TestCase;

class ExamplesTest extends TestCase
{
    public function test_CanRunWithoutOptions() {
        exec("php example/run", $out);
        self::assertEquals("   - list     List all commands", $out[0]);
        self::assertEquals("   - help     Show help for a command", $out[2]);
    }

    public function test_CanGetHelpForListCommand() {
        exec("php example/run list {help}", $out);
        self::assertEquals("Help for command list:", $out[0]);
        self::assertStringContainsString("list", $out[3]);
    }

    public function test_CanGetHelpForListCommandDifferent() {
        exec("php example/run help {list}", $out);
        self::assertEquals("Help for command list:", $out[0]);
        self::assertStringContainsString("list", $out[3]);
    }

    public function test_CanGetHelpForHelloCommand() {
        exec("php example/run help {hello}", $out);
        self::assertEquals("Help for command hello:", $out[0]);
    }

    public function test_CanRunHello() {
        exec("php example/run hello", $out);
        self::assertEquals("Hello!", $out[0]);
    }

    public function test_CanRunHelloName() {
        exec("php example/run hello [name=Artem]", $out);
        self::assertEquals("Hello, Artem!", $out[0]);
    }
}