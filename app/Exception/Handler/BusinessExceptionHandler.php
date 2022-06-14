<?php
declare(strict_types=1);

namespace App\Exception\Handler;

use App\Exception\BusinessException;
use App\Utils\Response;
use Hyperf\Di\Annotation\Inject;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * 业务异常处理
 */
class BusinessExceptionHandler extends ExceptionHandler
{
    /**
     * @Inject()
     * @var Response
     */
    private $response;

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        return $this->response->error($throwable->getCode(), $throwable->getMessage());
    }

    /**
     * 判断该异常处理器是否要对该异常进行处理
     */
    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof BusinessException;
    }

}