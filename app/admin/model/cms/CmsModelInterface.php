<?php

namespace app\admin\model\cms;

interface CmsModelInterface
{
    public function getColumnAll($param = null): array;
}