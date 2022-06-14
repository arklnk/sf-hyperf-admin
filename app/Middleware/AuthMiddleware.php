<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Middleware;

use App\Constants\RespondCode;
use App\Exception\AuthException;
use App\Utils\Auth;
use App\Utils\SysRedis;
use Hyperf\Utils\Context;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 登录验证中间件.
 */
class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * 验证是否登录
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $request->getHeaderLine('Authorization');
        $info = Auth::decode($token);
        $redis_token = SysRedis::getInstance()->get(config('system.login.token') . $info->data->uid);
        $redis_reset = SysRedis::getInstance()->get(config('system.login.reset') . $info->data->uid);
        // 判断当前token是否有效
        if (!$redis_token || $redis_token != $token || $redis_reset != 1) {
            throw new AuthException(RespondCode::getMessage(RespondCode::AUTH_EXPIRE), RespondCode::AUTH_EXPIRE);
        }
        Context::set('uid', $info->data->uid);
        return $handler->handle($request);
    }
}
