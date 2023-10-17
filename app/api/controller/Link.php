<?php

namespace app\api\controller;

//use app\api\validate\Catalog as Validate;
use app\common\controller\Frontend;
use think\exception\ValidateException;

//use app\api\model\Catalog as CatalogModel;

/**
 * 分类信息
 */
class Link extends Frontend
{
    protected array $noNeedLogin = ['index'];

    /**
     * 列表
     */
    public function index()
    {
        if ($this->request->isPost()) {
            try {
                $input = input('post.');
//                validate(Validate::class)->scene('index')->check($input);
            } catch ( ValidateException $e ) {
                return json(['status' => 'error', 'message' => $e->getError()]);
            }
            $search = ['keyword','status','type','show', 'level', 'pid'];
            $append = ['url'];
            $data   = \app\index\model\web\Catalog::withSearch($search, $input)->append($append)->order('weigh','desc')->select();
            $this->success('获取成功', $data);
        }
    }

    /**
     * 列表
     */
    public function link()
    {
        if ($this->request->isPost()) {
            try {
                $input = input('post.');
//                validate(Validate::class)->scene('index')->check($input);
            } catch ( ValidateException $e ) {
                return json(['status' => 'error', 'message' => $e->getError()]);
            }
            $search = [];
            $append = ['url'];
            $data   = \app\index\model\web\Module::withSearch($search, $input)->append($append)->order('weigh','desc')->select();
            $this->success('获取成功', $data);
        }
    }
}