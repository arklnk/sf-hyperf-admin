<?php

declare(strict_types=1);

namespace App\Controller;

use App\Utils\Response;
use Hyperf\Di\Annotation\Inject;

/**
 * 基类控制器
 */
class BaseController extends AbstractController
{
    /**
     * @Inject()
     * @var Response
     */
    protected $response;
}
