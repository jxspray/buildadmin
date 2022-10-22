<?php

namespace app\admin\model\cms;

use app\index\logics\CmsLogic;
use think\Model;

class Content extends Model
{
    public function __construct(string $name, array $data = [])
    {
        $this->name = CmsLogic::PREFIX . $name;
        parent::__construct($data);
    }
}
