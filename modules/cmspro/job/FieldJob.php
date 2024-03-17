<?php

namespace modules\cmspro\job;

use think\facade\Log;
use think\queue\Job;

class FieldJob extends BaseJob
{
    public function onSave(Job $job, $data)
    {
        try {
            $module = \app\admin\model\cms\Module::where('id', $data['id'])->find();
            if (!$module) {
                Log::error("Msg: 模型不存在！ID: {$data['id']}; File: " . __FILE__ . "; Line: " . __LINE__);
                $this->failed($data);

                $job->delete();
                return;
            }
            $instance = \ba\cms\utils\Sql::getInstance($module['name'], "CREATE");
            if (!$instance->tableExists()) {
                Log::error("Msg: 表不存在！ID: {$data['id']}; File: " . __FILE__ . "; Line: " . __LINE__);
                $this->failed($data);

                $job->delete();
                return;
            }
            $instance->createField($module);
        } catch (\Exception $e) {
            // 队列执行失败
            Log::error('queue-' . get_class()
                . ",执行失败，错误信息：{$e->getMessage()}, Line: {$e->getLine()}, File: {$e->getFile()}");
        }
        // 删除 job
        $job->delete();
    }
}
