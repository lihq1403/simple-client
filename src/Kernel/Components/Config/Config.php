<?php

declare(strict_types=1);
/**
 * This file is part of Lihq1403.
 */

namespace Lihq1403\SimpleClient\Kernel\Components\Config;

use Adbar\Dot;
use Lihq1403\SimpleClient\Kernel\Constants\SdkInfo;

class Config extends Dot
{
    public function getHost(): string
    {
        return $this->get('host', '');
    }

    public function getSdkName(): string
    {
        return $this->get('sdk_name', SdkInfo::NAME);
    }

    public function getSdkVersion(): string
    {
        return $this->get('sdk_version', SdkInfo::VERSION);
    }
}
