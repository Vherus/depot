<?php

namespace Depot\Resolution;

use Depot\Command;
use Depot\Exception\UnresolvableHandlerException;
use Depot\Stubs\AlternateTestCommand;
use Depot\Stubs\Handler\TestCommandHandler;
use Depot\Stubs\Handlers\AlternateTestCommandHandler;
use Depot\Stubs\TestCommand;

class NativeNamespaceResolverTest extends \PHPUnit_Framework_TestCase
{
    public function test_exception_thrown_if_handler_cannot_be_resolved()
    {
        $command = new class implements Command {};

        $this->expectException(UnresolvableHandlerException::class);

        (new NativeNamespaceResolver)->resolve($command);
    }

    public function test_handler_in_handler_sub_namespace_can_be_resolved()
    {
        $command = new TestCommand;

        $this->assertInstanceOf(TestCommandHandler::class, (new NativeNamespaceResolver)->resolve($command));
    }

    public function test_handler_in_handlers_sub_namespace_can_be_resolved()
    {
        $command = new AlternateTestCommand;

        $this->assertInstanceOf(AlternateTestCommandHandler::class, (new NativeNamespaceResolver)->resolve($command));
    }
}
