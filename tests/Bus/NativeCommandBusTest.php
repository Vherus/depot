<?php

namespace Depot\Bus;

use Depot\Resolution\NativeMapResolver;
use Depot\Resolution\NativeNamespaceResolver;
use Depot\Stubs\Handler\TestCommandHandler;
use Depot\Stubs\TestCommand;

class NativeCommandBusTest extends \PHPUnit_Framework_TestCase
{
    public function test_bus_calls_resolved_handlers_handle_method_using_namespace_resolver()
    {
        $bus = new NativeCommandBus(new NativeNamespaceResolver);

        $this->assertEquals('Handled', $bus->dispatch(new TestCommand));
    }

    public function test_bus_calls_resolved_handlers_handle_method_using_map_resolver()
    {
        $bus = new NativeCommandBus(new NativeMapResolver([TestCommand::class => TestCommandHandler::class]));

        $this->assertEquals('Handled', $bus->dispatch(new TestCommand));
    }
}
