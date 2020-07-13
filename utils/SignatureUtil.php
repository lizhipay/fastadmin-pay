<?php

namespace addons\lizhifu\utils;


/**
 *  签名算法
 * Class Signature
 * @package addons\lizhifu\utils
 */
class SignatureUtil
{
    /**
     * 生成签名数据
     * @param $data
     * @param $key
     * @return StringUtil
     */
    public static function generateSignature($data, $key)
    {
        unset($data['sign']);
        ksort($data);
        foreach ($data as $k => $v) {
            if ($v === '') {
                unset($data[$k]);
            }
        }
        return md5(urldecode(http_build_query($data) . "&key=" . $key));
    }

    /**
     * @return bool
     */
    public static function check($data, $key)
    {
        if ($data['sign'] != self::generateSignature($data, $key)) {
            return false;
        }

        return true;
    }
}