<?php

namespace Depot\Container;

use Depot\Container;

final class NativeContainer implements Container
{
    /**
     * @inheritdoc
     */
    public function make(string $class)
    {
        return new $class;
    }
}
