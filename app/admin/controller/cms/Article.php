<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;

/**
 * 文章模型
 *
 */
class Article extends Backend
{
    /**
     * Article模型对象
     * @var \app\admin\model\cms\Article
     */
    protected $model = null;
    
    protected $quickSearchField = ['id'];

    protected $defaultSortField = 'weigh,desc';

    protected $preExcludeFields = ['createtime', 'updatetime'];

    public function initialize()
    {
        parent::initialize();
        $this->model = new \app\admin\model\cms\Article;
    }

}