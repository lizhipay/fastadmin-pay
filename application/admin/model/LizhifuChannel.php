<?php

namespace app\admin\model;


use think\Model;

class LizhifuChannel extends Model
{

    // 表名
    protected $name = 'lizhifu_channel';
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
}