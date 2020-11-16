<?php


namespace App\HttpController;

/**
 * Description: 响应code
 * Class ResponseCode
 * @package App\HttpController
 */
class ResponseCode
{
    /**
     * @var int 没有参数
     */
    public static $noParams = 404;

    /**
     * @var int Redis写失败
     */
    public static $failRedis = 400;

    /**
     * @var int 成功
     */
    public static $success = 200;
}