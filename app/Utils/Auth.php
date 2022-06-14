<?php

namespace App\Utils;

use App\Constants\RespondCode;
use App\Exception\AuthException;
use Firebase\JWT\JWT;

/**
 * JWT处理根据
 */
class Auth
{

    /**
     * 生成token
     *
     * @param array $data
     * @return string
     */
    public static function encode(array $data): string
    {
        $payload = array(
            "exp" => time() + config('system.jwt.expire'),
            "data" => $data
        );
        return JWT::encode($payload, config('system.jwt.key'));
    }

    /**
     * 解析token
     *
     * @param string $token
     * @return object
     */
    public static function decode(string $token): object
    {
        try {
            return JWT::decode($token, config('system.jwt.key'), array('HS256'));
        } catch (\Exception $e) {
            throw new AuthException(RespondCode::getMessage(RespondCode::AUTH_FAIL), RespondCode::AUTH_FAIL);
        }
    }
}