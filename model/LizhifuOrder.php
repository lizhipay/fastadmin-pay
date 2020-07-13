<?php

namespace addons\lizhifu\model;


use think\Model;

/**
 * Class LizhifuOrder
 * @package addons\lizhifu\model
 */
class LizhifuOrder extends Model
{
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
}