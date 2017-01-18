<?php

namespace Depot\Resolution;

use Depot\Command;
use Depot\Container;
use Depot\Container\NativeContainer;
use Depot\HandlerResolver;
use Depot\Exception\UnresolvableHandlerException;

final class NativeNamespaceResolver implements HandlerResolver
{
    /**
     * @var NativeContainer
     */
    private $container;

    /**
     * NativeNamespaceResolver constructor
     * @param Container|null $container
     */
    public function __construct(Container $container = null)
    {
        $this->container = $container ?: new NativeContainer;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Command $command)
    {
        $command = get_class($command);
        $name = substr($command, strrpos($command, '\\') + 1);
        $namespace = substr($command, 0, strrpos($command, '\\'));

        $handler = "{$command}Handler";
        if (class_exists($handler)) {
            return $this->container->make($handler);
        }

        $handler = "$namespace\\Handlers\\{$name}Handler";
        if (class_exists($handler)) {
            return $this->container->make($handler);
        }

        $handler = "$namespace\\Handler\\{$name}Handler";
        if (class_exists($handler)) {
            return $this->container->make($handler);
        }

        throw new UnresolvableHandlerException("Unable to resolve handler for $command");
    }
}
