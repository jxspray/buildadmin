<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;
use ba\cms\Cms;

class Api extends Backend
{
    protected array $noNeedPermission = ['*'];

    public function clearCache(): void
    {
        $type = $this->request->post('type');
        if ($type == 'tp' || $type == 'all') {
            Cache::clear();
        } else {
            $this->error(__('Parameter error'));
        }
        Event::trigger('cacheClearAfter', $this->app);
        $this->success(__('Cache cleaned~'));
    }
    /**
     * 链接查询
     */
    public function link()
    {
        $table = $this->request->param('table');
        if ($table){
            $keyword = $this->request->post('keyword');
            $model = \app\admin\model\cms\Content::getInstance($table);
            // 模糊查找
            if (! empty($keyword)) {
                $where[] = ['title', 'like', '%'.$keyword.'%'];
            }
            // 状态正常
            $where[] = ['status', '=', 1];
            $data = $model->where($where)->field('id,title,url,catid')->limit(10)->select();
        } else {
            $data = \app\admin\model\cms\Module::where('status', '1')->where('type', '1')->select();
        }
        $this->success("获取成功", $data);
    }

    /**
     * 分类查询
     */
    public function catalog(): void
    {
        if ($this->request->isPost()) {
            $input = input('post.');
            $where[] = ['status', '=', 1];
//            $where[] = ['theme', '=', theme()];
            if (! empty($input['type'])) {
                $where[] = ['type','=', $input['type']];
            }
            $data  = \app\admin\model\cms\Catalog::where($where)->field('id,pid,title,seo_url,links_type,links_value,module_id')->order(['weigh'=>'desc'])->select();
            $this->success("获取成功", $data);
        }
    }

    public function param(): void
    {
        $this->success(__('Update successful'), config("cms.param"));
    }
}
