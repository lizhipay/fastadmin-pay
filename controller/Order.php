<?php

namespace addons\lizhifu\controller;


use addons\lizhifu\exception\TradeException;
use addons\lizhifu\model\LizhifuChannel;
use addons\lizhifu\model\LizhifuOrder;
use addons\lizhifu\utils\HttpUtil;
use addons\lizhifu\utils\SignatureUtil;
use addons\lizhifu\utils\StringUtil;
use fast\Auth;
use think\addons\Controller;
use think\Db;
use traits\controller\Jump;

/**
 * Class Trade
 * @package addons\lizhifu\controller
 */
class Order extends Controller
{
    /**
     * 无需登录的方法,同时也就不需要鉴权了
     * @var array
     */
    protected $noNeedLogin = [];
    /**
     * 无需鉴权的方法,但需要登录
     * @var array
     */
    protected $noNeedRight = ['trade'];

    /*
     * 权限Auth，如果用户是登录太，可以直接从中读取用户信息
     * @var Auth
     */
    protected $auth = null;

    use Jump;

    /**
     * @return StringUtil
     */
    public function trade()
    {
        $config = get_addon_config('lizhifu');

        $amount = (float)$this->request->post('amount');
        $channelId = (int)$this->request->post('channel_id');


        $data = [
            'merchant_id' => $config['merchant_id'],
            'amount' => $amount,
            'channel_id' => $channelId,
            'app_id' => $config['app_id'],
            'notification_url' => $this->request->domain() . '/addons/lizhifu/callback/notification',
            'sync_url' => $this->request->domain() . '/index/lizhifu/trade.html',
            'ip' => $this->request->ip(),
            'out_trade_no' => StringUtil::generateTradeNo(),
        ];

        $data['sign'] = SignatureUtil::generateSignature($data, $config['key']);

        $channel = LizhifuChannel::where("code", $channelId)->where("status", 1)->find();

        if (!$channel) {
            return $this->error('当前支付通道不存在或已停用');
        }

        //开启事务支持
        try {
            $url = Db::transaction(function () use ($data, $channel) {
                //先将订单入库
                $lizhifuOrder = new LizhifuOrder();
                $lizhifuOrder->trade_no = $data['out_trade_no'];
                $lizhifuOrder->amount = $data['amount'];
                $lizhifuOrder->channel_id = $channel->id;
                $lizhifuOrder->user_id = $this->auth->id;
                $lizhifuOrder->save();
                //开始请求CURL
                $request = HttpUtil::request('https://lizhifu.net/order/trade', $data);
                $json = json_decode($request, true);
                if ($json['code'] != 200) {
                    throw new TradeException((string)$json['msg']);
                }
                return $json['data']['url'];
            });

            $this->redirect($url);
        } catch (TradeException $e) {
            return $this->error($e->getMessage());
        }
    }
}