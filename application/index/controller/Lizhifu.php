<?php

namespace app\index\controller;


use addons\lizhifu\model\LizhifuChannel;
use addons\lizhifu\model\LizhifuOrder;
use app\common\controller\Frontend;

/**
 * Class Order
 * @package app\index\controller
 */
class Lizhifu extends Frontend
{

    protected $layout = 'default';
    protected $noNeedLogin = ['pay', 'epay'];
    protected $noNeedRight = ['*'];

    public function trade()
    {
        $config = get_addon_config('lizhifu');

        $moneyList = [];
        foreach ($config['moneylist'] as $index => $item) {
            $moneyList[] = ['value' => $item, 'text' => $index, 'default' => $item === $config['defaultmoney']];
        }

        $channels = LizhifuChannel::where("status", 1)->order("sort", "asc")->select();
        $this->view->assign('addonConfig', $config);
        $this->view->assign('moneyList', $moneyList);
        $this->view->assign('paytypeList', $channels);
        $this->view->assign('title', "余额充值");
        return $this->view->fetch();
    }

    public function order()
    {
        $moneyloglist = LizhifuOrder::where(['user_id' => $this->auth->id])
            ->order('id desc')
            ->paginate(5);
        $this->view->assign('title', '订单记录');
        $this->view->assign('moneyloglist', $moneyloglist);
        return $this->view->fetch();
    }
}