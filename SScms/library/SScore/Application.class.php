<?php

namespace SScore;

use SScore\Uri;
/**
 *
 */
class Application
{
    public static function start()
    {
        // 路由解析
        $response = Uri::detect();
        echo $response;
        // 实例化控制器
    }
}
