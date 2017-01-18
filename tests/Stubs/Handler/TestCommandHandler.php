<?php

namespace Depot\Stubs\Handler;

use Depot\Stubs\TestCommand;

class TestCommandHandler
{
    public function handle(TestCommand $command)
    {
        return 'Handled';
    }
}
