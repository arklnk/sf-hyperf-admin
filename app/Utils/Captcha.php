<?php

declare(strict_types=1);

namespace App\Utils;

use App\Constants\RespondCode;
use App\Exception\BusinessException;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

/**
 * 验证码工具类
 */
class Captcha
{

    /**
     * 创建验证码
     *
     * @param int $width
     * @param int $height
     * @return array
     */
    public static function create(int $width = 150, int $height = 40): array
    {
        $phraseBuilder = new PhraseBuilder(4, config('system.captcha.charset'));
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->setIgnoreAllEffects(true);
        $builder->build($width, $height);
        $id = uniqid('', false);
        return ['id' => $id, 'img' => $builder];
    }

    /**
     * 核对验证码
     *
     * @param string $id
     * @param string $verify
     */
    public static function check(string $id,string $verify)
    {
        $code = SysRedis::getInstance()->get($id);
        if ($verify != $code) {
            throw new BusinessException(RespondCode::getMessage(RespondCode::CAPTCHA_ERROR), RespondCode::CAPTCHA_ERROR);
        }
    }

    /**
     * 移除验证码
     *
     * @param $id
     */
    public static function remove($id)
    {
        SysRedis::getInstance()->del($id);
    }
}