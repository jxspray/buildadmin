<?php
declare(strict_types=1);

namespace ba\cms;

use think\facade\Db;

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

    public static function getInstance($name = '', $pattern = null)
    {
        static $oldName = '';
        if (self::$instance === false || $oldName != $name) {
            $name = strtolower($name);
            $prefix = env('database.prefix', 'ba_');
            $tableName = "cms_$name";
            $table = $prefix . $tableName;
            self::$instance = new self($table);
            $oldName = $name;
        }
        self::$instance->pattern = $pattern;
        return self::$instance;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    public function createTable($moduleRow): bool
    {
        list($sql, $fieldList) = $this->createField($moduleRow);

        $fieldsModel = new \app\admin\model\cms\Fields();
//        foreach ($fieldList as $item) {
//            $fieldsModel->save($item);
//        }
        $fieldsModel->saveAll($fieldList);
        Db::query("CREATE TABLE `$this->table` ($sql) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='{$moduleRow['title']}'");
        return true;
    }

    protected function createField(array $moduleRow): array
    {
        $data = [];
        $fieldList = [];
        $sqlList = [];
        switch ($moduleRow['template']) {
            case 'article':
                $data[] = $this->select('column', ['remark' => '栏目']);
                $data[] = $this->title('title', ['remark' => '标题']);
                $data[] = $this->text('keywords', ['remark' => '关键词']);
                $data[] = $this->textarea('description', ['remark' => '描述']);
                $data[] = $this->radio('status', ['default' => 0, 'listorder' => 99, 'remark' => '状态']);
                break;
            case 'empty':
                $data[] = $this->getTypeResult($this->getFieldDefaultInfo([
                    'name' => '状态',
                    'type' => 'radio',
                    'field' => 'status',
                    'setup' => ['options' => ['0' => '否', '1' => '是'], 'default' => 1],
                    'weigh' => 99
                ]));
                break;
        }
        $sqlList[] = "`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID'";
        $sqlList[] = "`weigh` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序'";
        $sqlList[] = "`lang` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '语言ID'";

        foreach ($data as $datum) {
            $sqlList[] = $datum[0];
            $datum[1]['moduleid'] = $moduleRow['id'];
            $fieldList[] = $datum[1];
        }

        $sqlList[] = "PRIMARY KEY (`id`)";
        return [implode(", ", $sqlList), $fieldList];
    }

    public function getFieldDefaultInfo($data){
        $data['createtime'] = time();
        $data['comment'] = $data['remark'] = $data['name'];
        return $data;
    }

    /**
     * @param $field
     * @return bool|object
     */
    public function fieldExists($field)
    {
        if (empty($field)) return false;
        return Db::query("DESC `{$this->table}` `$field`");
    }

    /**
     * @param $field
     * @return bool|object
     */
    public function tableExists()
    {
        return Db::query("SHOW TABLES LIKE '{$this->table}'");
    }

    public function deleteTable()
    {
        Db::execute("DROP TABLE {$this->table}");
        return true;
    }

    public function deleteField($field): bool
    {
        /* 检查字段是否存在 */
        if ($this->fieldExists($field)) {
            $this->execute($this->getHead($field, 'DROP'));
            return true;
        }
        return false;
    }

    public function execute($sql): bool
    {
        Db::execute("ALTER TABLE `{$this->table}` $sql");
        return true;
    }

    /**
     * 获取sql和setup
     * @param array $data
     * @param array $originData
     * @param array $checkChange
     * @return bool|array
     */
    public function getTypeResult(array $data, array $originData = [], array $checkChange = [])
    {
        if ($checkChange) {
            $bool = false;
            foreach ($checkChange as $field) {
                if ($data[$field] != $originData[$field]) {
                    $bool = true;
                    break;
                }
            }
            if ($bool === false) return false;
        }
        if (method_exists($this, $data['type'])) {
            list($sql, $setup) = $this->{$data['type']}($data);
            $sql = "{$this->getHead($data['field'], $originData['field']??'')} $sql";
            $data['setup'] = $setup;
            return [$sql, $data];
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
        if ($this->pattern == 'CREATE') return "`$field`";
        if ($originField == 'DROP') $do = "DROP";
        else {
            if (!empty($originField)) {
                $do = $this->fieldExists($originField) ? (($originField != $field) ? "CHANGE" : "MODIFY") : "ADD";
                /* 如果数据表原字段不存在，检查新字段是否存在 */
                if ($do == "ADD" && $this->fieldExists($field)) abort(405, "字段已存在");
                if ($do == "CHANGE") $field = "`$originField` `$field`";
            } else {
                $do = $this->fieldExists($field) ? "CHANGE COLUMN" : "ADD";
            }
        }
        return "$do COLUMN `$field`";
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

    public function text(array $res): array
    {
        extract($res);
        return [$this->_varchar($setup, $comment ?? ''), $setup];
    }

    public function select(array $res): array
    {
        extract($res);
        return [$this->_varchar($setup, $comment ?? ''), $setup];
    }

    public function radio(array $res): array
    {
        extract($res);
        $setup['options'] = $setup['options'] ?? ['0' => '否', '1' => '是'];
        return [$this->_enum($setup, $comment ?? ''), $setup];
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

    public function image(array $res): array
    {
        extract($res);
        return [$this->_varchar($setup, $comment ?? ''), $setup];
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
        $length = (int)$length;
        switch ($type) {
            case 'varchar':
                if ($length <= 0) $length = 255;
                else if ($length > 65535) $length = 65535;
                break;
        }
        return $length;
    }

    /*```````````````````````````````````````````` 数据库操作Begin ``````````````````````````````````````````````*/
    private function _varchar(&$args = [], $comment = ''): string
    {
        if (($res = sql_inject($args)) !== true) abort(502, $res);
        $default = NULL;
        $args['maxlength'] = $this->getLength('varchar', $args['maxlength'] ?? 0);
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

    private function _enum($args = [], $comment = ''): string
    {
        if (($res = sql_inject($args)) !== true) abort(405, $res);
        $default = NULL;
        extract($args);
        $options = array_keys($options);
//        if (in_array($default, $options)) $default = "NOT NULL DEFAULT '$default'";
//        else if ($default === NULL) $default = "DEFAULT NULL";
        $default = "DEFAULT NULL";
        $str = '';
        foreach ($options as $option) {
            if ($str) $str .= ", ";
            $str .= "'$option'";
        }
        if (!empty($comment)) $comment = "COMMENT '$comment'";
        return "enum( $str ) $default $comment";
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
