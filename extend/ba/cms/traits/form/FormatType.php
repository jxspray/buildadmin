<?php

namespace ba\cms\traits\form;

trait FormatType
{

    /* ######################################################### 组件 ######################################################## */
    /**
     * @param array $data
     * @return string
     */
    public function text(array $data): string
    {
        extract($data);
        $setupType = $setup['type'] ?? 'string';
        return match ($setupType) {
            "string", "textarea", "password" => $this->_varchar($setup),
            "number" => $this->_int($setup),
        };
    }

    /**
     * @param array $data
     * @return string
     */
    public function select(array $data): string
    {
        extract($data);
        return $this->_varchar($setup);
    }

    public function radio(array $data): string
    {
        extract($data);
        $setup['options'] = $setup['options'] ?? ['否', '是'];
        return $this->_enum($setup);
    }

    /**
     * @param array $data
     * @return string
     */
    public function image(array $data): string
    {
        extract($data);
        return $this->_varchar($setup);
    }

    /**
     * @param array $data
     * @return string
     */
    public function remoteSelect(array $data): string
    {
        extract($data);
        return $this->_int($setup);
    }

    public function editor(array $data): string
    {
        extract($data);
        return $this->_text($setup);
    }

}
