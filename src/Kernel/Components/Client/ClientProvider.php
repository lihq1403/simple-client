<?php

declare(strict_types=1);
/**
 * This file is part of Lihq1403.
 */

namespace Lihq1403\SimpleClient\Kernel\Components\Client;

use GuzzleHttp\Client;
use Lihq1403\SimpleClient\Kernel\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ClientProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['client'] = function (Application $pimple) {
            if ($client = $pimple->config->get('component.client')) {
                if ($client instanceof Client) {
                    return $client;
                }
            }
            return (new ClientFactory())();
        };

        $pimple['clientRequest'] = function (Application $pimple) {
            return new ClientRequest($pimple);
        };
    }
}
