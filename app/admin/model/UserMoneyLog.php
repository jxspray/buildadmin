<?php

namespace app\admin\model;

use Throwable;
use think\model;
use think\Exception;
use think\model\relation\BelongsTo;

/**
 * UserMoneyLog 模型
 */
class UserMoneyLog extends model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime         = false;

    /**
     * 入库前
     * @throws Throwable
     */
    public static function onBeforeInsert($model)
    {
        $user = User::where('id', $model->user_id)->find();
        if (!$user) {
            throw new Exception("The user can't find it");
        }
        if (!$model->memo) {
            throw new Exception("Change note cannot be blank");
        }
        $model->before = $user->money;
        $model->after  = $user->money + $model->money;
    }

    /**
     * 入库后
     * @throws Throwable
     */
    public static function onAfterInsert($model)
    {
        $user = User::where('id', $model->user_id)->find();
        if (!$user) {
            $model->delete();
            throw new Exception("The user can't find it");
        }
        $user->money += $model->money;
        $user->save();
    }

    public static function onBeforeDelete(): bool
    {
        return false;
    }

    public function getMoneyAttr($value): string
    {
        return bcdiv($value, 100, 2);
    }

    public function setMoneyAttr($value): string
    {
        return bcmul($value, 100, 2);
    }

    public function getBeforeAttr($value): string
    {
        return bcdiv($value, 100, 2);
    }

    public function setBeforeAttr($value): string
    {
        return bcmul($value, 100, 2);
    }

    public function getAfterAttr($value): string
    {
        return bcdiv($value, 100, 2);
    }

    public function setAfterAttr($value): string
    {
        return bcmul($value, 100, 2);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}