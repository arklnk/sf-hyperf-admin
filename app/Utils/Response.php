<?php

declare(strict_types=1);

namespace App\Utils;

use App\Constants\RespondCode;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\ResponseInterface;

/**
 * 请求响应工具类
 */
class Response
{
    /**
     * @Inject()
     * @var ResponseInterface
     */
    protected $response;

    /**
     * 返回json格式
     *
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function json(array $data): \Psr\Http\Message\ResponseInterface
    {
        return $this->response->json($data);
    }

    /**
     * 业务处理成功
     *
     * @param array $data
     * @param string $message
     * @param int $code
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function success(array $data = [], string $message = 'success', int $code = RespondCode::SUCCESS): \Psr\Http\Message\ResponseInterface
    {
        return $this->response->json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * 系统异常
     *
     * @param int $code
     * @param string $message
     * @return mixed
     */
    public function fail(int $code = RespondCode::SERVER_ERROR, string $message = '')
    {
        if (is_null($message)) {
            $message = RespondCode::getMessage($code);
        }
        return $this->response->withStatus(500)->json([
            'code' => $code,
            'message' => $message,
        ]);
    }

    /**
     * 业务处理失败
     *
     * @param int $code
     * @param string $message
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function error(int $code = RespondCode::ERROR, $message = ''): \Psr\Http\Message\ResponseInterface
    {
        if (is_null($message)) {
            $message = RespondCode::getMessage($code);
        }
        return $this->response->json([
            'code' => $code,
            'message' => $message,
        ]);
    }
}