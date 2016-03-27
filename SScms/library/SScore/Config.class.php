<?php

namespace SScore;

use SScore\ArrayHandle;
/**
 * get and set application configution
 */
class Config
{
    private static $array = array();

    public static function get($key, $fallback = null)
    {
        $keys = explode('.', $key);

        if (! array_key_exists($file = array_shift($keys), static::$array)) {
            if (is_readable($path = CONFIG_PATH.$file.'EXT')) {
                static::$array[$file] = require $path;
            }
        }
        return ArrayHandle::get(static::$array, $key, $fallback);
    }

    public static function set($key, $value)
    {
        ArrayHandle::set(static::$array, $key, $value);
    }

    public static function erase($key)
    {
        ArrayHandle::erase(static::$array, $key);
    }

    public static function __callStatic($method, $arguments)
    {
        $key = $method;
        $fallback = null;
        if (count($arguments [, $mode])) {
            $key .= '.'.array_shift($arguments);
            $fallback = array_shift($arguments);
        }
        return static::get($key, $fallback);
    }
}
