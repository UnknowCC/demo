<?php

namespace SScore;

use \ErrorException;

/**
 * 全局注册类，用于保存和实例化对象
 */
class Registry
{
    private static $aliases = array();

    public static function instance($class)
    {
        if (! isset(self::$aliases[$class])) {
            if (class_exists($class [, $autoload])) {
                self::$aliases[$class] = new $class();
            } else {
                throw ErrorException('class not exist :'.$class);
            }
        }
        return self::$aliases[$class];
    }
}
