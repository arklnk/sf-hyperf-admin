<?php

declare(strict_types=1);

namespace App\Business\Admin;

use App\Constants\RespondCode;
use App\Exception\BusinessException;
use App\Model\SysAdmin;
use App\Utils\Auth;
use App\Utils\Captcha;
use App\Utils\SysRedis;
use Hyperf\Di\Annotation\Inject;

class IndexBusiness
{
    /**
     * @Inject()
     * @var SysAdmin
     */
    public $sysAdmin;

    /**
     * 登录
     *
     * @param array $params
     * @return string
     */
    public function login(array $params): string
    {
        // 核对验证码
        Captcha::check(config('system.captcha.prefix') . $params['captchaId'], $params['verifyCode']);
        // 获取登录用户信息
        $user = $this->getUser($params['username'], $params['password']);
        // 生成登录token
        $token = Auth::encode(['username' => $user['username'], 'uid' => $user['id']]);
        // 登录信息写入redis
        SysRedis::getInstance()->set(config('system.login.reset') . $user['id'], 1);
        SysRedis::getInstance()->set(config('system.login.token') . $user['id'], $token);
        // 删除已经被使用过的登录验证码
        Captcha::remove(config('system.captcha.prefix') . $params['captchaId']);
        return $token;
    }

    /**
     * 验证码
     *
     * @return array
     */
    public function img(): array
    {
        $captcha = Captcha::create();
        SysRedis::getInstance()->set(config('system.captcha.prefix') . $captcha['id'], $captcha['img']->getPhrase(), config('system.captcha.ttl'));
        return $captcha;
    }

    /**
     * 获取用户信息
     *
     * @param string $username
     * @param string $password
     * @return array
     */
    public function getUser(string $username, string $password): array
    {
        $user = $this->sysAdmin->getItem([['username', '=', $username]], ['username', 'id', 'password', 'psalt', 'status']);
        if (empty($user) || $user['password'] !== md5($password . $user['psalt'])) {
            throw new BusinessException(RespondCode::getMessage(RespondCode::ACCOUNT_ERROR), RespondCode::ACCOUNT_ERROR);
        }
        if ($user['status'] === 0) {
            throw new BusinessException(RespondCode::getMessage(RespondCode::ACCOUNT_FORBIDDEN), RespondCode::ACCOUNT_FORBIDDEN);
        }
        return $user;
    }

}