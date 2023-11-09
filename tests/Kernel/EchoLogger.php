<?php

declare(strict_types=1);
/**
 * This file is part of Lihq1403.
 */

namespace Lihq1403\SimpleClient\Test\Kernel;

use Psr\Log\AbstractLogger;

class EchoLogger extends AbstractLogger
{
    public function log($level, $message, array $context = [])
    {
        var_dump($level, $message, $context);
    }
}
