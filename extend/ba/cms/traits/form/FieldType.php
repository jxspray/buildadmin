<?php

namespace ba\cms\traits\form;

trait FieldType
{

    /* ####################################################### 常用字段类型 ###################################################### */
    /* ======================================================== 数字类型 ===================================================== */

    /**
     * int 整型
     * @param array $args
     * @return string
     */
    public function _int(array $args = []): string
    {
        extract($args);
        return "INT( $length )";
    }
    // float 浮点数
    // double 双精度浮点数
    // tinyint 小整型
    // smallint 小整型
    // bigint 长整型
    // decimal 定点数
    // mediumint 中等整型
    /* ======================================================= 日期和时间类型 ==================================================== */
    // datetime 日期时间
    // timestamp 时间戳
    // date 日期
    // time 时间
    // year 年份
    /* ======================================================== 字符串类型 ===================================================== */
    // varchar 可变字符串
    private function _varchar($args = []): string
    {
        extract($args);
        return "VARCHAR( $length )";
    }

    // enum 枚举
    private function _enum($args = []): string
    {
        extract($args);
        $options = array_keys($options);
        $str = '';
        foreach ($options as $option) {
            if ($str) $str .= ", ";
            $str .= "'$option'";
        }
        return "enum( $str )";
    }
    // longtext 长文本
    // text 文本
    private function _text($args = []): string
    {
        extract($args);
        return "TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
    }
    // mediumtext 中等文本
    // char 字符串
    /* ======================================================= 特殊数据类型 ===================================================== */
    // blob 二进制大对象
    // binary 二进制
    // bit 位
    // geometry 几何
    // geometrycollection 几何集合
    // integer 整型
    // json JSON
    // linestring 线
    // longblob 长二进制
    // mediumblob 中等二进制
    // multilinestring 多线
    // multipoint 多点
    // multipolygon 多面
    // numeric 定点数
    // point 点
    // polygon 面
    // real 浮点数
    // set 集合
    // tinyblob 小二进制
    // tibytext 小文本
    // varbinary 可变二进制
}
