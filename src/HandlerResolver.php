<?php

namespace Depot;

use Depot\Exception\UnresolvableHandlerException;

interface HandlerResolver
{
    /**
     * @param Command $command
     * @return Handler
     * @throws UnresolvableHandlerException
     */
    public function resolve(Command $command);
}
