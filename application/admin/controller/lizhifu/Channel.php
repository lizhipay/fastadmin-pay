<?php

namespace app\admin\controller\lizhifu;


use app\common\controller\Backend;

class Channel extends Backend
{
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('LizhifuChannel');
    }
}