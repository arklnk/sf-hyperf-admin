<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
#[Constants]
class RespondCode extends AbstractConstants
{
    /**
     * @Message("Success")
     */
    const SUCCESS = 200;

    /**
     * @Message("Error")
     */
    const ERROR = 400;

    /**
     * @Message("Not Found")
     */
    const NOT_FOUND = 404;

    /**
     * @Message("Server Error!")
     */
    const SERVER_ERROR = 500;

    /**
     * @Message("Auth fail")
     */
    const AUTH_FAIL = 11001;

    /**
     * @Message("Auth invalid")
     */
    const AUTH_EXPIRE = 11002;

    /**
     * @Message("Account or password error")
     */
    const ACCOUNT_ERROR = 11003;

    /**
     * @Message("Account invalid")
     */
    const ACCOUNT_FORBIDDEN = 11004;

    /**
     * @Message("Captcha error")
     */
    const CAPTCHA_ERROR = 11005;

    /**
     * @Message("Params error")
     */
    const PARAM_ERROR = 11006;

}
