<?php

declare(strict_types=1);
/**
 * This file is part of Lihq1403.
 */

namespace Lihq1403\SimpleClient\Kernel;

use GuzzleHttp\Client;
use Lihq1403\SimpleClient\Kernel\Components\Client\ClientProvider;
use Lihq1403\SimpleClient\Kernel\Components\Client\ClientRequest;
use Lihq1403\SimpleClient\Kernel\Components\Config\Config;
use Lihq1403\SimpleClient\Kernel\Components\Logger\Logger;
use Lihq1403\SimpleClient\Kernel\Components\Logger\LoggerProvider;
use Pimple\Container;

/**
 * Class Application.
 *
 * @property Config $config
 * @property Logger $logger
 * @property Client $client
 * @property ClientRequest $clientRequest
 */
class Application extends Container
{
    protected array $providers = [
        LoggerProvider::class,
        ClientProvider::class,
    ];

    public function __construct(array $config = [])
    {
        parent::__construct();

        $this->registerConfig($config);
        $this->registerProviders();
    }

    public function __get(string $id)
    {
        return $this->offsetGet($id);
    }

    public function __set(string $id, $value)
    {
        $this->offsetUnset($id);
        $this->offsetSet($id, $value);
    }

    protected function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->register(new $provider());
        }
    }

    protected function registerConfig(array $config)
    {
        $this['config'] = function () use ($config) {
            return new Config($config);
        };
    }
}
