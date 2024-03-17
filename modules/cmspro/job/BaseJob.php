<?php

namespace modules\cmspro\job;

class BaseJob
{
    public function failed($data)
    {
        // 记录日志
        \think\facade\Db::name('cms_failed_job')->insert([
            'data' => json_encode($data),
            'createtime' => time(),
            'updatetime' => time()
        ]);
    }
}
