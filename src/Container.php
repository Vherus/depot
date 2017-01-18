<?php

namespace Depot;

interface Container
{
    /**
     * @param string $class
     * @return object
     */
    public function make(string $class);
}
