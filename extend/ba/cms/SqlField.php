<?php

namespace ba\cms;

use app\admin\model\cms\Fields;
use think\facade\Db;
use think\Model;

class SqlField
{
    /**
     * 表名
     * @var string $table
     */
    protected $table;
    /**
     * 操作：ADD=添加，CHANGE=修改
     * @var string $do
     */
    protected $do;

    /**
     * 模式：CREATE=创建模式
     * @var string $pattern
     */
    protected $pattern;

    public function __construct($table, $pattern = null)
    {
        $this->pattern = $pattern;
        $this->table = $table;
    }

    /**
     * @var self
     */
    private static $instance = false;

    public static function getInstance($name){
        static $oldName = '';
        if (self::$instance === false || $oldName != $name) {
            $name = strtolower($name);
            $prefix = env('database.prefix', 'ba_');
            $tableName = "cms_$name";
            $table = $prefix . $tableName;
            self::$instance = new self($table);
            $oldName = $name;
        }
        return self::$instance;
    }

    /**
     * 获取sql和setup
     * @param $res
     * @return bool|array
     */
    public function getTypeResult($data, $originData = null)
    {
        if (method_exists($this, $data['type'])) {
            list($sql, $setup) = $this->{$data['type']}($data);
            return ["ALTER TABLE `{$this->table}` {$this->getHead($data['field'], $originData['field']??'')} $sql", $setup];
        }
        return false;
    }

    private function handleData($field, $data)
    {
        $data['field'] = $field;
        $data['listorder'] = $data['listorder'] ?? 0;
        $data['moduleid'] = $data['moduleid'] ?? 0;
        $data['issystem'] = $data['issystem'] ?? 1;
        $data['required'] = $data['required'] ?? 0;
        $data['setup'] = json_encode($data['setup'] ?? [], JSON_UNESCAPED_UNICODE);
        return $data;
    }

    public function handleSetup($type, $setup = [])
    {
        switch ($type) {
            case 'checkbox':
            case 'radio':
                $setup = array_merge(['labelwidth' => 45, 'default' => 0], $setup);
                break;
            case 'editor':
                $setup = array_merge(['edittype' => 'ueditor', 'toolbar' => 'full', 'default' => '', 'height' => '', 'show_auto_thumb' => 1, 'showpage' => 0], $setup);
                break;
        }
        return $setup;
    }

    public function getHead($field, $originField = ''): string
    {
        if (!empty($originField)) {
            $do = Db::query("DESC `{$this->table}` `$originField`") ? (($originField != $field) ? "CHANGE" : "MODIFY") : "ADD";
            /* 如果数据表原字段不存在，检查新字段是否存在 */
            if ($do == "ADD" && Db::query("DESC `{$this->table}` `$field`")) abort(405, "字段已存在");
            if ($do == "CHANGE") $field = "`$originField` `$field`";
        } else {
            $do = Db::query("DESC `{$this->table}` `$field`") ? "CHANGE COLUMN" : "ADD";
        }
        return "$do COLUMN $field";
    }

    /*```````````````````````````````````````````` 模型字段操作Begin ``````````````````````````````````````````````*/
    public function catid($field, $args = []): array
    {
        $data = [];
        extract($args);
        $default = $default ?? 0;
        $remark = $remark ?? '栏目';
        return [$this->_smallint($field, ['default' => $default], $remark), $this->handleData($field, array_merge([
            'type' => __FUNCTION__,
            'name' => $remark,
            'required' => 1
        ], $data))];
    }

    public function title(array $res): array
    {
        extract($res);
        return [$this->_varchar($field, $setup, $comment??''), $setup];
    }

    public function text(array $res): array
    {
        extract($res);
        return [$this->_varchar($field, $setup, $comment??''), $setup];
    }

    public function textarea($field, $args = []): array
    {
        $data = [];
        extract($args);
        $default = $default ?? 0;
        $remark = $remark ?? '多行文本';
        return [$this->_varchar($field, ['default' => $default], $remark), $this->handleData($field, [
            'type' => __FUNCTION__,
            'name' => $remark,
            'setup' => ['rows' => '6', 'cols' => '48']
        ])];
    }

    public function tags($field, $args = []): array
    {
        $data = [];
        extract($args);
        $default = $default ?? 0;
        $remark = $remark ?? '标签';
        return [$this->_varchar($field, ['maxlength' => 120, 'default' => $default], $remark), $this->handleData($field, [
            'listorder' => 19,
            'type' => __FUNCTION__,
            'name' => $remark,
        ])];
    }

    public function number($field, $args = []): array
    {
        $data = [];
        extract($args);
        $default = $default ?? 0;
        $remark = $remark ?? '数字';

        $fdata = $this->handleData($field, array_merge([
            'type' => __FUNCTION__,
            'name' => $remark,
        ], $data));
        if (($numbertype ?? 1) == 1) {
            return [$this->_int($field, ['default' => $default, 'maxlength' => $maxlength ?? 11], $remark), $fdata];
        } else {
            return [$this->_decimal($field, ['default' => $default, 'maxlength' => $maxlength ?? 5, 'minlength' => $minlength ?? 2], $remark), $fdata];
        }
    }

    public function checkbox($field, $args = []): array
    {
        $data = [];
        extract($args);
        $default = $default ?? '';
        $remark = $remark ?? '多选';
        $options = $options ?? [];
        return [$this->_varchar($field, ['maxlength' => 120, 'default' => $default], $remark), $this->handleData($field, array_merge([
            'type' => __FUNCTION__,
            'name' => $remark,
            'setup' => $this->handleSetup('checkbox', ['options' => $options, 'labelwidth' => 60])
        ], $data))];
    }

    public function radio($field, $args = []): array
    {
        $data = [];
        extract($args);
        $default = $default ?? '';
        $remark = $remark ?? '多选';
        $options = $options ?? ['0' => '否', '1' => '是'];
        return [$this->_enum($field, ['default' => $default, 'options' => array_keys($options)], $remark), $this->handleData($field, array_merge([
            'type' => __FUNCTION__,
            'name' => $remark,
            'setup' => $this->handleSetup('radio', ['options' => $options, 'default' => 1])
        ], $data))];
    }

    public function image($field, $args = []): array
    {
        $data = [];
        extract($args);
        $default = $default ?? '';
        $remark = $remark ?? '图片';
        return [$this->_tinyint($field, ['default' => $default], $remark), $this->handleData($field, array_merge([
            'type' => __FUNCTION__,
            'name' => $remark,
            'setup' => ['remak' => $remark, 'upload_maxsize' => '5', 'upload_allowext' => 'jpg,jpeg,gif,png', 'watermark' => '0', 'more' => '0']
        ], $data))];
    }

    public function editor($field, $args = []): array
    {
        $data = [];
        extract($args);
        $default = $default ?? '';
        $remark = $remark ?? '内容';
        return [$this->_tinyint($field, ['default' => $default], $remark), $this->handleData($field, array_merge([
            'type' => __FUNCTION__,
            'name' => $remark,
            'setup' => $this->handleSetup('editor')
        ], $data))];
    }

    private function getLength($type, $length): int
    {
        $length = (int) $length;
        switch ($type) {
            case 'int':
                if ($length <= 0) $length = 255;
                else if ($length > 65535) $length = 65535;
                break;
        }
        return $length;
    }

    /*```````````````````````````````````````````` 数据库操作Begin ``````````````````````````````````````````````*/
    private function _varchar($field, &$args = [], $comment = ''): string
    {
        if ($res = sql_inject($args) !== true) abort(405, $res);
        $default = NULL;
        $args['maxlength'] = $this->getLength('int', $args['maxlength']);
        extract($args);
        if ($default === NULL) $default = "DEFAULT NULL";
        else $default = "NOT NULL DEFAULT '$default'";
        if (!empty($comment)) $comment = "COMMENT '$comment'";

        return "VARCHAR( $maxlength ) $default $comment";
    }

    private function _smallint($field, $args = [], $remark = ''): string
    {
        $default = NULL;
        $maxlength = 5;
        extract($args);
        if ($default === NULL) $default = "DEFAULT NULL";
        else $default = "UNSIGNED NOT NULL DEFAULT $default";
        if (!empty($remark)) $remark = "COMMENT '$remark'";

        return "{$this->getHead()} `$field` SMALLINT($maxlength) $default $remark";
    }

    private function _decimal($field, $args = [], $remark = ''): string
    {
        $default = NULL;
        $maxlength = 5;
        $minlength = 2;
        extract($args);
        if ($default === NULL) $default = "DEFAULT NULL";
        else $default = "UNSIGNED NOT NULL DEFAULT '$default'";
        if (!empty($remark)) $remark = "COMMENT '$remark'";

        return "{$this->getHead()} `$field` DECIMAL( $maxlength, $minlength ) $default $remark";
    }

    private function _tinyint($field, $args = [], $remark = ''): string
    {
        $default = NULL;
        $maxlength = 1;
        extract($args);
        if ($default === NULL) $default = "DEFAULT NULL";
        else $default = "NOT NULL DEFAULT $default";
        if (!empty($remark)) $remark = "COMMENT '$remark'";

        return "{$this->getHead()} `$field` TINYINT( $maxlength ) $default $remark";
    }

    private function _enum($field, $args = [], $remark = ''): string
    {
        extract($args);
        $default = (isset($default) && $default !== '' && in_array($default, $options)) ? $default : 'NULL';

        if (!empty($remark)) $remark = "COMMENT '$remark'";

        $str = '';
        foreach ($options as $option) {
            if ($str) $str .= ", ";
            $str .= "'{$option}'";
        }
        return "{$this->getHead()} `$field` enum( $str ) DEFAULT '$default' $remark";
    }


    private function _int($field, $args = [], $remark = ''): string
    {
        $default = NULL;
        $maxlength = 11;
        extract($args);
        if ($default === NULL) $default = "DEFAULT NULL";
        else $default = "NOT NULL DEFAULT $default";
        if (!empty($remark)) $remark = "COMMENT '$remark'";

        return "{$this->getHead()} `$field` TINYINT( $maxlength ) $default $remark";
    }

    private function _text($field, $args = [], $remark = ''): string
    {
        $default = NULL;
        extract($args);
        if ($default === NULL) $default = "";
        else $default = "NOT NULL";
        if (!empty($remark)) $remark = "COMMENT '$remark'";

        return "{$this->getHead()} `$field` $default TEXT $remark";
    }
}
