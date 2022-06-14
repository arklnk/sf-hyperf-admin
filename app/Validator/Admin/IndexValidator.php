<?php

declare(strict_types=1);

namespace App\Validator\Admin;

use App\Validator\BaseValidator;

class IndexValidator extends BaseValidator
{
    /**
     * 验证规则
     * @var array
     */
    protected $rule = [
        'username' => 'required',
        'password' => 'required',
        'captchaId' => 'required',
        'verifyCode' => 'required'
    ];

    /**
     * 验证提示
     * @var array
     */
    protected $message = [
    ];

    /**
     * 使用场景
     * @var array
     */
    protected $scene = [
    ];

}