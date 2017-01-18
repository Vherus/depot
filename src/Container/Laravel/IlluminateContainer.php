<?php

namespace Depot\Container\Laravel;

use Depot\Container;
use Illuminate\Contracts\Container\Container as Laravel;

final class IlluminateContainer implements Container
{
    /**
     * @var Laravel
     */
    private $container;

    /**
     * IlluminateContainer constructor
     * @param Laravel $container
     */
    public function __construct(Laravel $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritdoc
     */
    public function make(string $class)
    {
        return $this->container->make($class);
    }
}
