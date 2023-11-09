<?php

declare(strict_types=1);
/**
 * This file is part of Lihq1403.
 */

namespace Lihq1403\SimpleClient\Test\Kernel;

use GuzzleHttp\Client;
use Lihq1403\SimpleClient\Kernel\Application;
use Lihq1403\SimpleClient\Kernel\Components\Client\ClientRequest;
use Lihq1403\SimpleClient\Kernel\Components\Config\Config;
use Lihq1403\SimpleClient\Kernel\Components\Logger\Logger;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ApplicationTest extends TestCase
{
    public function testCreate()
    {
        $app = new Application();

        $this->assertInstanceOf(Application::class, $app);
        $this->assertInstanceOf(Config::class, $app->config);
        $this->assertInstanceOf(Client::class, $app->client);
        $this->assertInstanceOf(ClientRequest::class, $app->clientRequest);
        $this->assertInstanceOf(Logger::class, $app->logger);

        $app->logger = new EchoLogger();
        $this->assertInstanceOf(EchoLogger::class, $app->logger);

        $app = new Application([
            'host' => 'https://www.baidu.com',
            'sdk_name' => 'xxx',
            'sdk_version' => '1.0.1',
            'component' => [
                'logger' => new EchoLogger(),
            ],
        ]);
        $this->assertInstanceOf(Logger::class, $app->logger);
        $this->assertEquals('xxx', $app->config->getSdkName());
        $this->assertEquals('1.0.1', $app->config->getSdkVersion());
    }
}
