<?php

use Hyperf\Amqp\Message\ProducerMessage;
use Hyperf\Amqp\Producer;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Redis\Redis;
use Hyperf\Server\ServerFactory;
use Hyperf\Utils\ApplicationContext;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;

/**
 * 容器实例
 *
 * @return ContainerInterface
 */
function container(): ContainerInterface
{
    return ApplicationContext::getContainer();
}

/**
 * Redis 客户端实例
 *
 * @return Redis|mixed
 */
function redis()
{
    return container()->get(Redis::class);
}

/**
 * Server 实例 基于 Swoole Server
 *
 * @return \Swoole\Coroutine\Server|\Swoole\Server
 */
function server()
{
    return container()->get(ServerFactory::class)->getServer()->getServer();
}

/**
 * WebSocket frame 实例
 *
 * @return mixed|Frame
 */
function frame()
{
    return container()->get(Frame::class);
}

/**
 * WebSocketServer 实例
 *
 * @return mixed|WebSocketServer
 */
function websocket()
{
    return container()->get(WebSocketServer::class);
}

/**
 * 缓存实例 简单的缓存
 *
 * @return mixed|\Psr\SimpleCache\CacheInterface
 */
function cache()
{
    return container()->get(Psr\SimpleCache\CacheInterface::class);
}

/**
 * 控制台日志
 *
 * @return StdoutLoggerInterface|mixed
 */
function stdout_log()
{
    return container()->get(StdoutLoggerInterface::class);
}

/**
 * 文件日志
 *
 * @param string $name
 * @return \Psr\Log\LoggerInterface
 */
function logger(string $name = 'APP')
{
    return container()->get(LoggerFactory::class)->get($name);
}

/**
 * Http 请求实例
 *
 * @return mixed|ServerRequestInterface
 */
function request()
{
    return container()->get(ServerRequestInterface::class);
}

/**
 * 请求响应
 *
 * @return ResponseInterface|mixed
 */
function response()
{
    return container()->get(ResponseInterface::class);
}

/**
 * RabbitMQ生产者
 *
 * @param ProducerMessage $message
 * @param bool $confirm
 * @param int $timeout
 * @return bool
 */
function producer_amqp(ProducerMessage $message, bool $confirm = false, int $timeout = 5)
{
    return container()->get(Producer::class)->produce($message, $confirm, $timeout);
}

/**
 * 获取当前毫秒时间
 *
 * @return float
 */
function millisecond(): float
{
    list($mse, $sec) = explode(' ', microtime());
    return (float)sprintf('%.0f', (floatval($mse) + floatval($sec)) * 1000);
}

function gen_file_name($fileName,$param,$argument){
    if(!file_exists($fileName.'/'.$param.'.php')){
        if(count($argument) > 1){
            foreach ($argument as $k=> $name){
                $fileName .= '/' . $name;
                if($k<(count($argument)-1) && !file_exists($fileName)){
                    if (!mkdir($concurrentDirectory = $fileName) && !is_dir($concurrentDirectory)) {
                        throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
                    }
                }
                if($k===(count($argument)-1)){
                    $fileName .= '.php';
                    touch($fileName);
                }
            }
        }else{
            $fileName .= '/' . $param . '.php';
            touch($fileName);
        }
    }else{
        $fileName .= '/' . $param . '.php';
    }
    return $fileName;
}