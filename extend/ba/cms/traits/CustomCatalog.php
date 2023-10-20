<?php

namespace ba\cms\traits;

use app\index\logics\Url;

trait CustomCatalog
{

    public function getLinksValueAttr($value, $row)
    {
        return !$value ? '' : $value;
    }

    public function getUrlAttr($value, $array): string
    {
        return $array['links_type'] === 1 ? Url::appoint($array['links_value'], false) : Url::catalog($array, false);
    }
}
