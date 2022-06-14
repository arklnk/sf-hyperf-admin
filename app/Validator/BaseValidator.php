<?php

declare(strict_types=1);

namespace App\Validator;

use App\Constants\RespondCode;
use App\Exception\BusinessException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class BaseValidator
{
    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    protected $validationFactory;

    /**
     * @Inject()
     * @var RequestInterface
     */
    protected $request;

    /**
     * 验证规则
     * @var array
     */
    protected $rule = [
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

    /**
     * 场景验证器
     *
     * @param string $scene
     * @return array
     */
    public function validate($scene = '*'): array
    {
        $rules = [];
        if ($scene === '*') {
            $rules = $this->rule;
        } else {
            $queue = $this->scene[$scene];
            foreach ($queue as $item) {
                $rules[$item] = $this->rule[$item];
            }
        }
        $validator = $this->validationFactory->make(
            $this->request->all(),
            $rules,
            $this->message
        );
        if ($validator->fails()) {
            throw new BusinessException($validator->errors()->first(), RespondCode::PARAM_ERROR);
        }
        return $this->request->all();
    }
}