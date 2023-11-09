<?php

declare(strict_types=1);
/**
 * This file is part of Lihq1403.
 */

namespace Lihq1403\SimpleClient\Kernel\Exceptions;

use Lihq1403\SimpleClient\Kernel\Constants\ErrorCode;

class BadRequestException extends SimpleClientException
{
    public function __construct(string $message = '', int $code = ErrorCode::BAD_REQUEST, \Throwable $throwable = null)
    {
        $message = "[{$code}][BadRequest]{$message}";
        parent::__construct($message, $code, $throwable);
    }
}
