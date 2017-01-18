<?php

namespace Depot;

interface Handler
{
    /**
     * @param Command $command
     * @return mixed
     */
    public function handle(Command $command);
}
