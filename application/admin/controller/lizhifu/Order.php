<?php

namespace app\admin\controller\lizhifu;


use app\admin\model\LizhifuOrder;
use app\common\controller\Backend;

/**
 * Class Order
 * @package app\admin\controller\lizhifu
 */
class Order extends Backend
{
    /**
     * @var LizhifuOrder
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('LizhifuOrder');
    }

    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with(['user', 'channel'])
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }
}