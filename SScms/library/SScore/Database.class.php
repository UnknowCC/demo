<?php

namespace SScore;

/**
 * 数据库接口
 */
class Database
{
    private static $connection;

    /**
     * 单例模式 实例化数据库连接类
     */
    private function __construct()
    {
        if (empty(Config::db())) {
            die('数据库参数未配置');
        }
        try {
            static::$connection = new database\driver\Mysql($config);
        } catch (\PDOException $e) {
            throw new ErrorException('Database connect error:'.$e->getMessage());
        }

    }

    /**
     * 获得数据库连接实例类
     * @return object 
     */
    public static function connection()
    {
        if (empty(static::$connection)) {
            static::$connection = new static();
        }
        return static::$connection;
    }
}
