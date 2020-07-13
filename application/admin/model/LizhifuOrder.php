<?php

namespace app\admin\model;


use think\Model;

class LizhifuOrder extends Model
{
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';


    /**
     * 用户信息
     * @return \think\model\relation\HasOne
     */
    public function user()
    {
        return $this->hasOne(\app\common\model\User::class, 'id', 'user_id');
    }

    /**
     * 支付通道
     * @return \think\model\relation\HasOne
     */
    public function channel()
    {
        return $this->hasOne(LizhifuChannel::class, 'id', 'channel_id');
    }
}