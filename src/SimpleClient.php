<?php

declare(strict_types=1);
/**
 * This file is part of Lihq1403.
 */

namespace Lihq1403\SimpleClient;

use Lihq1403\SimpleClient\Kernel\Application;
use Lihq1403\SimpleClient\Kernel\Constants\RequestMethod;
use Lihq1403\SimpleClient\Kernel\Exceptions\BadRequestException;
use Lihq1403\SimpleClient\Kernel\Exceptions\SystemException;
use Psr\Http\Message\ResponseInterface;

/**
 * @method ResponseInterface get(string $url, array $options = [])
 * @method ResponseInterface post(string $url, array $options = [])
 * @method ResponseInterface put(string $url, array $options = [])
 * @method ResponseInterface patch(string $url, array $options = [])
 * @method ResponseInterface delete(string $url, array $options = [])
 */
class SimpleClient
{
    protected Application $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @param mixed $name
     * @param mixed $arguments
     * @throws BadRequestException
     * @throws SystemException
     */
    public function __call($name, $arguments)
    {
        if (in_array($name, RequestMethod::allow())) {
            return $this->application->clientRequest->request($name, ...$arguments);
        }
        throw new SystemException("no allowed method [{$name}]");
    }
    
    public function getApplication(): Application
    {
        return $this->application;
    }
}
