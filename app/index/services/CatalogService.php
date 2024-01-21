<?php

namespace app\index\services;


use ba\cms\utils\Tree;

class CatalogService
{
    public static $catalogList = [];
    public static $catalog = [];
    public static $catalogHeader = [];
    public static $catalogFooter = [];
    public static $crumbs = [];
    /**
     * @var $request \app\index\model\web\Catalog|null
     */
    private static $model = null;
    /**
     * @var $request \app\Request|null
     */
    private static $request = null;
    public static function init(\app\Request $request): void
    {
        self::$model = new \app\index\model\web\Catalog();
        self::$request = $request;
        self::$catalogList = self::$model->where('status', 1)->order('weigh','desc')
            ->cache()->append(['url', 'route'])->select()->toArray();
        self::$catalogList = array_combine(array_column(self::$catalogList, 'id'), self::$catalogList);
    }
}
