<?php

namespace SScore\database;

/**
 * 创建查询语句的抽象基类
 */
abstract class Builder
{
    /**
     * 为数据库表和查询字段添加包围符号
     * @param  [type] $field [description]
     * @return [type]        [description]
     */
    public function wrap($field)
    {
        if (is_array($field)) {
            $fields = array();

            foreach ($field as $val) {
                $fields = $this->wrap($val);
            }
            return implode(', ', $fields);
        }
        return $this->enclose($field);
    }
}
