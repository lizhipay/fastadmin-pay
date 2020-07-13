<?php

namespace addons\lizhifu\controller;


use addons\lizhifu\model\LizhifuOrder;
use addons\lizhifu\utils\SignatureUtil;
use app\common\model\User;
use think\addons\Controller;
use think\Db;

/**
 * Class Callback
 * @package addons\lizhifu\controller
 */
class Callback extends Controller
{

    /**
     * @return string
     */
    public function notification()
    {
        $config = get_addon_config('lizhifu');
        $map = $this->request->post();
        if (!SignatureUtil::check($map, $config['key'])) {
            return 'signature error';
        }

        if ($map['status'] != 1) {
            return 'status error';
        }

        //订单入库，增加会员金额
        Db::transaction(function () use ($map) {
            $order = LizhifuOrder::where("trade_no", $map['out_trade_no'])->where("status", 0)->find();
            if (!$order) {
                return;
            }
            //给会员加钱
            $user = User::where("id", $order->user_id)->find();
            $user->money = $user->money + $order->amount;
            $user->save();
            //修改订单状态
            $order->paytime = time();
            $order->status = 1;
            $order->save();
        });

        return 'success';
    }
}