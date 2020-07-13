<?php
namespace addons\lizhifu\utils;

/**
 * Class StringUtil
 * @package App\Utils
 */
class StringUtil
{

    /**
     * 生成订单号
     * @return StringUtil
     */
    public static function generateTradeNo()
    {
        mt_srand();
        return date("ymdHis", time()) . mt_rand(100000, 999999);
    }

}