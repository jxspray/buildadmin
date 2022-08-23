<?php
// 这是系统自动生成的公共文件

/**
 * 区分大小写的文件存在判断
 * @param string $filename 文件地址
 * @return boolean
 */
function file_exists_case($filename): bool
{
    if (is_file($filename)) {
        if (basename(realpath($filename)) != basename($filename)) return false;
        return true;
    }
    return false;
}