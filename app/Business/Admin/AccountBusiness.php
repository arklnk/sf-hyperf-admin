<?php

declare(strict_types=1);

namespace App\Business\Admin;

use App\Model\SysAdmin;
use App\Utils\SysRedis;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Context;

class AccountBusiness
{
    /**
     * 登录信息
     *
     * @Inject()
     * @var SysAdmin
     */
    public $sysAdmin;

    public function info(): array
    {
        return $this->sysAdmin->getItem([['id', '=', Context::get('uid')]], ['name', 'head_img']);
    }

    /**
     * 退出
     */
    public function logout()
    {
        $key = [
            config('system.login.reset') . Context::get('uid'),
            config('system.login.token') . Context::get('uid'),
        ];
        SysRedis::getInstance()->del(...$key);
    }
}