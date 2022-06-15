<?php
declare(strict_types=1);

namespace App\Exception\Handler;


use App\Constants\RespondCode;
use App\Utils\Response;
use Hyperf\Di\Annotation\Inject;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * 验证器异常处理
 */
class ParamExceptionHandler extends ExceptionHandler
{
    /**
     * @Inject()
     * @var Response
     */
    protected $response;

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        $message = $throwable->validator->errors()->first();
        return $this->response->error(RespondCode::PARAM_ERROR, $message);
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }

}