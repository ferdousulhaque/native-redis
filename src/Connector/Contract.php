<?php

namespace NativeSupport\PHPRedis\Connector;

interface Contract
{
    public function connect(\Redis $redis): bool;
}
