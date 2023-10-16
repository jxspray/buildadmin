<?php
// +----------------------------------------------------------------------
// | OneKeyAdmin [ Believe that you can do better ]
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2023 http://onekeyadmin.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: MUKE <513038996@qq.com>
// +----------------------------------------------------------------------
namespace app\api\validate;

use think\Validate;

class Catalog extends Validate
{
    protected $rule = [
        'id'     => 'require|number',
        'status' => 'number',
        'show'   => 'number',
    ];
    
    protected $scene = [
        'index'  => ['status','show'],
        'sigle'  => ['id'],
    ];
}