<?php

namespace app\api\controller;

use app\common\controller\Frontend;
use app\api\validate\Catalog as Validate;
use think\exception\ValidateException;
use app\api\model\Catalog as CatalogModel;

/**
 * 分类信息
 */
class Catalog extends Frontend
{
    /**
     * 列表
     */
    public function index()
    {
        if ($this->request->isPost()) {
            try {
                $input = input('post.');
                validate(Validate::class)->scene('index')->check($input);
            } catch ( ValidateException $e ) {
                return json(['status' => 'error', 'message' => $e->getError()]);
            }
            $search = ['keyword','status','type','show', 'level', 'pid'];
            $append = ['url'];
            $data   = CatalogModel::withSearch($search, $input)->append($append)->order('sort','desc')->select();
            return json(['status' => 'success', 'message' => '获取成功', 'data' => $data]);
        }
    }

}