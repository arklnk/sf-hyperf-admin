<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Business\Admin\IndexBusiness;
use App\Controller\BaseController;
use App\Validator\Admin\IndexValidator;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 登录模块
 *
 * @Controller(prefix="/admin")
 */
class IndexController extends BaseController
{
    /**
     * @Inject()
     * @var IndexValidator
     */
    protected $indexValidator;

    /**
     * @Inject()
     * @var IndexBusiness
     */
    protected $indexBusiness;

    /**
     * 获取验证码
     *
     * @RequestMapping(path="captcha/img",methods={"GET"})
     */
    public function img(): ResponseInterface
    {
        $captcha = $this->indexBusiness->img();
        return $this->response->success(['id' => $captcha['id'], 'img' => $captcha['img']->inline()]);
    }

    /**
     * 管理员登录
     *
     * @RequestMapping(path="login",methods={"POST"})
     * @return ResponseInterface
     */
    public function login(): ResponseInterface
    {
        $params = $this->indexValidator->validate();
        $token = $this->indexBusiness->login($params);
        return $this->response->success(['token' => $token]);
    }

}
