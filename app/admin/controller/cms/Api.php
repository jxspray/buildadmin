<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;

class Api extends Backend
{
    /**
     * 链接查询
     */
    public function link()
    {
        $input = input('post.');
        if (!isset($input['table'])){
            $data = \app\admin\model\cms\Module::where('status', '1')->where('type', '1')->select();
        } else {
            $model = \app\admin\model\cms\Content::getInstance($input['table']);
            // 模糊查找
            if (! empty($input['keyword'])) {
                $where[] = ['title', 'like', '%'.$input['keyword'].'%'];
            }
            // 状态正常
            $where[] = ['status', '=', 1];
            $data = $model->where($where)->field('id,title,url,catid')->limit(10)->select();
        }
        $this->success("获取成功", $data);
    }

    /**
     * 分类查询
     */
    public function catalog() {
        if ($this->request->isPost()) {
            $input = input('post.');
            $where[] = ['status', '=', 1];
//            $where[] = ['theme', '=', theme()];
            if (! empty($input['type'])) {
                $where[] = ['type','=', $input['type']];
            }
            $data  = \app\admin\model\cms\Catalog::where($where)->field('id,pid,title,seo_url,links_type,links_value')->order(['weigh'=>'desc'])->select();
            $this->success("获取成功", $data);
        }
    }
}