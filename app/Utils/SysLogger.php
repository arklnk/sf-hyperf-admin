<?php

declare(strict_types=1);

namespace App\Utils;

use Hyperf\Logger\LoggerFactory;
use Hyperf\Utils\ApplicationContext;

/**
 * 系统日志工具类
 */
class SysLogger
{
    public static function getInstance(string $name = 'log', string $group = 'default')
    {
        return ApplicationContext::getContainer()->get(LoggerFactory::class)->get($name, $group);
    }
}