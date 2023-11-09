<?php

declare(strict_types=1);
/**
 * This file is part of Lihq1403.
 */

namespace Lihq1403\SimpleClient\Kernel\Components\Logger;

use Lihq1403\SimpleClient\Kernel\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class LoggerProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['logger'] = function (Application $pimple) {
            return new Logger($pimple->config->get('component.logger'));
        };
    }
}
