<?php

namespace addons\lizhifu;

use app\common\library\Menu;
use think\Addons;
use think\Request;

/**
 * 插件
 */
class Lizhifu extends Addons
{

    /**
     * 插件安装方法
     * @return bool
     * @throws \think\Exception
     */
    public function install()
    {
        $menu = [
            [
                'name'    => 'lizhifu',
                'title'   => '支付管理',
                'icon'    => 'fa fa-viadeo',
                'sublist' => [
                    [
                        'name'    => 'lizhifu/channel',
                        'title'   => '支付通道',
                        'icon'    => 'fa fa-th-list',
                        'sublist' => [
                            ['name' => 'lizhifu/channel/index', 'title' => '查看'],
                            ['name' => 'lizhifu/channel/del', 'title' => '删除']
                        ]
                    ],
                    [
                        'name'    => 'lizhifu/order',
                        'title'   => '订单管理',
                        'icon'    => 'fa fa-shopping-cart',
                        'sublist' => [
                            ['name' => 'lizhifu/orders/data', 'title' => '订单数据'],
                        ]
                    ],
                ]
            ]
        ];
        Menu::create($menu);
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        Menu::delete("lizhifu");
        return true;
    }

    /**
     * 插件启用方法
     * @return bool
     * @throws \think\Exception
     */
    public function enable()
    {
        Menu::enable("lizhifu");
        return true;
    }

    /**
     * 插件禁用方法
     * @return bool
     */
    public function disable()
    {
        Menu::disable("lizhifu");
        return true;
    }

    /**
     * 会员中心边栏后
     * @return mixed
     * @throws \Exception
     */
    public function userSidenavAfter()
    {
        $request = Request::instance();
        $actionname = strtolower($request->action());
        $data = [
            'actionname' => $actionname
        ];
        return $this->fetch('view/hook/user_sidenav_after', $data);
    }
}
