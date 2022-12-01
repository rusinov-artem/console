<?php

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use RusinovArtem\Console\App;
use RusinovArtem\Console\BuildInput;
use RusinovArtem\Console\Command\ShowHelp;
use RusinovArtem\Console\Command\ShowList;
use RusinovArtem\Console\DefaultDispatcher;
use RusinovArtem\Console\Event\AfterExecution;
use RusinovArtem\Console\Event\BeforeExecution;
use RusinovArtem\Console\Event\CommandReceived;
use RusinovArtem\Console\Input;
use RusinovArtem\Console\Test\OutSpy;

class AppTest extends TestCase
{
    public function test_CanRunDefaultCommand()
    {
        $app = new App([
            'list' => ShowList::class,
        ]);

        $app->setEventDispatcher(DefaultDispatcher::build());

        $out = new OutSpy();
        $app->run(new Input(), $out);

        self::assertStringContainsString("List all commands", $out->stdout);
    }

    public function test_CanGetHelp()
    {
        $app = new App([
            'help' => ShowHelp::class,
        ]);

        $out = new OutSpy();
        $app->run(BuildInput::from("help", "{help}"), $out);

        self::assertStringContainsString("usage", $out->stdout);
    }


    public function test_CanUSerDI()
    {
        $diContainer = $this->getContainer();
        $dispatcher = $this->getDispatcher();

        $app = new App([
            'default' => ShowList::class,
            'help' => ShowHelp::class,
            'SomeCommand' => "id"
        ]);

        $app->setContainer($diContainer);
        $app->setEventDispatcher($dispatcher);

        $out = new OutSpy();
        $app->run(BuildInput::from("SomeCommand", "{arg1}"), $out);

        self::assertTrue($diContainer->hasInvoked);
        self::assertTrue($diContainer->getInvoked);
        self::assertCount(3, $dispatcher->events);
        self::assertInstanceOf(CommandReceived::class, $dispatcher->events[0]);
        self::assertInstanceOf(BeforeExecution::class, $dispatcher->events[1]);
        self::assertInstanceOf(AfterExecution::class, $dispatcher->events[2]);
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return new class implements ContainerInterface {
            public bool $getInvoked = false;
            public bool $hasInvoked = false;

            public function get(string $id)
            {
                $this->getInvoked = true;
                return new RusinovArtem\Console\Command\Command();
            }

            public function has(string $id): bool
            {
                $this->hasInvoked = true;
                return true;
            }
        };
    }

    protected function getDispatcher()
    {
        return new class implements EventDispatcherInterface {
            public $events = [];

            public function dispatch(object $event)
            {
                $this->events[] = $event;
            }
        };
    }
}