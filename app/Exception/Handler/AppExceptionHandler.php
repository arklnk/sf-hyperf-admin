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

namespace App\Exception\Handler;

use App\Constants\RespondCode;
use App\Utils\Response;
use App\Utils\SysLogger;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * 系统异常处理
 */
class AppExceptionHandler extends ExceptionHandler
{
    /**
     * @var StdoutLoggerInterface
     */
    protected $logger;

    /**
     * @Inject()
     * @var Response
     */
    protected $response;

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        SysLogger::getInstance('log', 'exception')->error($throwable->getMessage());
        return $this->response->fail(RespondCode::SERVER_ERROR, $throwable->getMessage());
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
