<?php

declare(strict_types=1);

namespace App\Utils;

use Hyperf\Utils\Str;

/**
 * 数据格式化根据
 */
class DataFormat
{
    /**
     * 下划线转驼峰
     *
     * @param array $data
     * @return array
     */
    public static function underscoreToHump(array $data): array
    {
        $params = [];
        if ($data) {
            foreach ($data as $key => $value) {
                if (!is_int($key)) {
                    if (is_array($value)) {
                        $params[Str::camel($key)] = self::underscoreToHump($value);
                    } else {
                        $params[Str::camel($key)] = $value;
                    }
                } else if (is_array($value)) {
                    $params[$key] = self::underscoreToHump($value);
                } else {
                    $params[$key] = $value;
                }
            }
        }
        return $params;
    }

    /**
     * 驼峰转下划线
     *
     * @param array $data
     * @return array
     */
    public static function humpToUnderscore(array $data): array
    {
        $params = [];
        if ($data) {
            foreach ($data as $key => $value) {
                if (!is_int($key)) {
                    if (is_array($value)) {
                        $params[Str::snake($key)] = self::humpToUnderscore($value);
                    } else {
                        $params[Str::snake($key)] = $value;
                    }
                } else if (is_array($value)) {
                    $params[$key] = self::humpToUnderscore($value);
                } else {
                    $params[$key] = $value;
                }
            }
        }
        return $params;
    }
}