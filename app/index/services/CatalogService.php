<?php

namespace app\index\services;


use app\index\model\web\Catalog;
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
    public static $mode = "";
    public static $configField = null;
    public static function init(\app\Request $request): void
    {
        self::$model = new \app\index\model\web\Catalog();
        self::$request = $request;
        if ($request->isMobile()) self::$mode = "wap";
        else self::$mode = "pc";
        self::$catalogList = self::$model->where('status', 1)->order('weigh','desc')
            ->cache()->append(['url', 'route'])->select()->toArray();
        self::$catalogList = array_combine(array_column(self::$catalogList, 'id'), self::$catalogList);
        self::$configField = \app\index\model\web\Config::load("catalog", "common")->value;
        foreach (self::$configField as &$item) {
            $item = self::$model->getTopFieldAttr($item, []);
        }
    }

    public static function request()
    {
        return self::$request;
    }
}
