<?php

namespace Depot\Resolution;

use Depot\Command;
use Depot\Container;
use Depot\Container\NativeContainer;
use Depot\Exception\UnresolvableHandlerException;
use Depot\HandlerResolver;

final class NativeMapResolver implements HandlerResolver
{
    /**
     * @var string[]
     */
    private $commands;
    /**
     * @var Container
     */
    private $container;

    /**
     * NativeMapResolver constructor
     * @param string[] $commands
     * @param Container $container
     */
    public function __construct(array $commands, Container $container = null)
    {
        $this->commands = $commands;
        $this->container = $container ?: new NativeContainer;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Command $command)
    {
        if (array_key_exists($command = get_class($command), $this->commands)) {
            return $this->container->make($this->commands[$command]);
        }

        throw new UnresolvableHandlerException("Unable to resolve handler for $command");
    }
}
