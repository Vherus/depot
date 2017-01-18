<?php

namespace Depot\Resolution;

use Depot\Exception\UnresolvableHandlerException;
use Depot\Stubs\Handler\TestCommandHandler;
use Depot\Stubs\TestCommand;

class NativeMapResolverTest extends \PHPUnit_Framework_TestCase
{
    public function test_handler_can_be_resolved_from_map()
    {
        $resolver = new NativeMapResolver([
            TestCommand::class => TestCommandHandler::class
        ]);

        $this->assertInstanceOf(TestCommandHandler::class, $resolver->resolve(new TestCommand));
    }

    public function test_exception_thrown_if_handler_cannot_be_resolved()
    {
        $this->expectException(UnresolvableHandlerException::class);

        (new NativeMapResolver([]))->resolve(new TestCommand);
    }
}
