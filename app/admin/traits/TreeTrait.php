<?php

namespace app\admin\traits;

use ba\Tree;

trait TreeTrait
{
    /**
     * @var Tree
     */
    protected $tree = null;

    protected $keyword = false;

    /**
     * @var array 远程select初始化传值
     */
    protected $initValue;

    /**
     * @var bool 是否组装Tree
     */
    protected $assembleTree;

    public function treeInit()
    {
        $this->tree = Tree::instance();

        $isTree = $this->request->param('isTree', true);
        $this->initValue = $this->request->get("initValue/a", '');
        $this->keyword = $this->request->request("quick_search");

        $this->assembleTree = $isTree && !$this->keyword && !$this->initValue;
    }
}