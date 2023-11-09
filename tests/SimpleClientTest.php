<?php

declare(strict_types=1);
/**
 * This file is part of Lihq1403.
 */

namespace Lihq1403\SimpleClient\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Lihq1403\SimpleClient\Kernel\Application;
use Lihq1403\SimpleClient\SimpleClient;
use Lihq1403\SimpleClient\Test\Kernel\EchoLogger;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class SimpleClientTest extends TestCase
{
    public function testRequest()
    {
        $response = new Response(200, [], '{"success": true}');
        $client = \Mockery::mock(Client::class);
        $client->allows()->request('GET', 'https://restapi.amap.com/v3/weather/weatherInfo', [
            'query' => [
                'key' => 'mock-key',
                'city' => '深圳',
                'output' => 'json',
                'extensions' => 'base',
            ],
        ])->andReturn($response);

        $config = [
            'host' => 'https://restapi.amap.com',
            'sdk_name' => 'xxx',
            'sdk_version' => '1.0.1',
            'component' => [
                'logger' => new EchoLogger(),
                'client' => $client,
            ],
        ];
        $app = new Application($config);

        $simpleClient = new SimpleClient($app);
        $actualResponse = $simpleClient->get('/v3/weather/weatherInfo', [
            'query' => [
                'key' => 'mock-key',
                'city' => '深圳',
                'output' => 'json',
                'extensions' => 'base',
            ],
        ]);
        $this->assertEquals($response, $actualResponse);
    }
}
