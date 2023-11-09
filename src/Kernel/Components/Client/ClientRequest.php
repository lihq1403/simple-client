<?php

declare(strict_types=1);
/**
 * This file is part of Lihq1403.
 */

namespace Lihq1403\SimpleClient\Kernel\Components\Client;

use GuzzleHttp\Client;
use Lihq1403\SimpleClient\Kernel\Application;
use Lihq1403\SimpleClient\Kernel\Components\Config\Config;
use Lihq1403\SimpleClient\Kernel\Components\Logger\Logger;
use Lihq1403\SimpleClient\Kernel\Exceptions\BadRequestException;
use Psr\Http\Message\ResponseInterface;

class ClientRequest
{
    protected Client $client;

    protected Config $config;

    protected Logger $logger;

    public function __construct(Application $application)
    {
        $this->config = $application->config;
        $this->logger = $application->logger;
        $this->client = $application->client;
    }

    /**
     * @throws BadRequestException
     */
    public function request(string $method, string $uri = '', array $options = []): ResponseInterface
    {
        $parseUrl = parse_url($uri);
        if (!isset($parseUrl['host'])) {
            $uri = $this->config->getHost() . $uri;
        }

        $start = microtime(true);
        $content = '';
        try {
            $response = $this->client->request(strtoupper($method), $uri, $options);
            $content = $response->getBody()->getContents();
            if ($response->getStatusCode() != 200) {
                throw new BadRequestException($content, $response->getStatusCode());
            }
            $response->getBody()->rewind();
            return $response;
        } catch (\Throwable $throwable) {
            throw new BadRequestException($throwable->getMessage(), $throwable->getCode());
        } finally {
            if (isset($throwable)) {
                $content = json_encode([
                    'code' => $throwable->getCode(),
                    'message' => '[bad_request]' . $throwable->getMessage(),
                    'file' => $throwable->getFile(),
                    'line' => $throwable->getLine(),
                ], JSON_UNESCAPED_UNICODE);
            }
            $this->log($method, $uri, $options, $content, $start);
        }
    }

    private function log(string $method, string $uri, array $options, string $content, float $startTime = null): void
    {
        $elapsedTime = round((microtime(true) - $startTime) * 1000, 2);
        $this->logger->info(
            $this->config->getSdkName(),
            [
                'method' => $method,
                'uri' => $uri,
                'options' => $options,
                'content' => $content,
                'elapsed_time' => $elapsedTime,
            ]
        );
    }
}
