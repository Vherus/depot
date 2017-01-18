<?php

namespace Depot;

interface CommandBus
{
    /**
     * @param Command $command
     * @return mixed
     */
    public function dispatch(Command $command);
}
