<?php

namespace Depot\Bus;

use Depot\Command;
use Depot\CommandBus;
use Depot\HandlerResolver;

final class NativeCommandBus implements CommandBus
{
    /**
     * @var HandlerResolver
     */
    private $resolver;

    /**
     * NativeCommandBus constructor
     * @param HandlerResolver $resolver
     */
    public function __construct(HandlerResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param Command $command
     * @return mixed
     */
    public function dispatch(Command $command)
    {
        return $this->resolver->resolve($command)->handle($command);
    }
}
