<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Business\Admin\AccountBusiness;
use App\Controller\BaseController;
use App\Middleware\AuthMiddleware;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 账户模块
 *
 * @Controller(prefix="/admin/account")
 * @Middleware(AuthMiddleware::class)
 */
class AccountController extends BaseController
{
    /**
     * @Inject()
     * @var AccountBusiness
     */
    protected $accountBusiness;

    /**
     * 获取登录信息
     *
     * @RequestMapping(path="info",methods={"GET"})
     * @return ResponseInterface
     */
    public function info(): ResponseInterface
    {
        $user = $this->accountBusiness->info();
        return $this->response->success($user);
    }

    /**
     * 登出
     *
     * @RequestMapping(path="logout",methods={"POST"})
     * @return ResponseInterface
     */
    public function logout(): ResponseInterface
    {
        $this->accountBusiness->logout();
        return $this->response->success();
    }

}
