<?php

declare(strict_types=1);

namespace App\Utils;

use Hyperf\Redis\RedisFactory;
use Hyperf\Utils\ApplicationContext;

/**
 * 系统redis工具类
 */
class SysRedis
{
    public static function getInstance($poolName = 'default')
    {
        $container = ApplicationContext::getContainer();
        return $container->get(RedisFactory::class)->get($poolName);
    }
}