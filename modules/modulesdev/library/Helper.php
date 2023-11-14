<?php

namespace modules\modulesdev\library;

use ba\Filesystem;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Helper
{
    public static function dir(string $path, $key = 'path', $label = 'label'): array
    {
        $unsetKey   = [
            '.',
            '..',
            '.idea',
            'Desktop.ini',
        ];
        $data       = scandir($path);
        $returnData = [];
        foreach ($data as $datum) {
            if (!in_array($datum, $unsetKey)) {
                $fullPath     = $path . $datum;
                $returnData[] = [
                    $key   => $fullPath,
                    $label => $datum,
                    'dir'  => !is_dir($fullPath),
                ];
            }
        }
        return $returnData;
    }

    public static function pack(string $dir, string $fileName): bool
    {
        // 文件列表
        $files    = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::LEAVES_ONLY
        );
        $fileList = [];
        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePathName = $file->getPathName();
                $fileList[]   = [
                    'file' => str_replace(root_path(), '', $filePathName),
                    'name' => str_replace($dir, '', $filePathName),
                ];
            }
        }
        return Filesystem::zip($fileList, $fileName);
    }

    /**
     * 目录文件列表
     * @param string $dir 目录
     */
    public static function dirFiles(string $dir): array
    {
        $dirFiles = [];
        $files    = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($files as $file) {
            if (!$file->isDir()) {
                $dirFiles[] = $file->getPathName();
            }
        }
        return $dirFiles;
    }

    /**
     * 删除模块文件或文件夹
     */
    public static function delModuleFileOrDir(string $path): bool
    {
        if (!$path) return false;
        if (is_file($path)) {
            @unlink($path);
        } elseif (is_dir($path)) {
            Filesystem::delDir($path);
        }
        return true;
    }
}