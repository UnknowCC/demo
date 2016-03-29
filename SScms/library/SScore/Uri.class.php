<?php

namespace SScore;

use SScore\ArrayHandle;
use \ReflectionClass;
use \ReflectionMethod;
/**
 *
 */
class Uri
{
    /**
     * 路由解析 实例化控制器
     * @return [type] [description]
     */
    public static function detect()
    {
        ob_start();
        $server = $_SERVER;
        $requestUri = ArrayHandle::get($server, 'PATH_INFO');
        $requestUri = explode('/', trim($requestUri, '/'));
        $controller = array_shift($requestUri) ?: 'index';
        define('__CONTROLLER__', $controller);
        $controller = '\\controller\\'.ucfirst(strtolower($controller)).'Controller';
        //echo (new $controller)->index();
        if (class_exists($controller)) {
            $reflectionController = new ReflectionClass($controller);
            $action = array_shift($requestUri) ?: 'index';
            define('__ACTION__', $action);
            if ($reflectionController->hasMethod(strtolower($action))) {
                $reflectionAction = $reflectionController->getMethod($action);
                 return $reflectionAction->invoke(new $controller());
            }
        } else {
            $reflectionAction = new ReflectionMethod('\\controller\\IndexController', 'wrong');
            return $reflectionAction->invoke(null);

        }
    }

    /**
     * 执行网页重定向
     * @param  string  $url  重定向的URL地址
     * @param  integer $time 跳转等待时间
     * @param  string  $msg  等待期间提示信息
     * @return void        
     */
    public static function redirect($url, $time = 0, $msg = '')
    {
        $url = str_replace(array("\n", "\r"), '', $url);

        if (empty($msg)) {
            $msg = '网页将在<b>'.$time.'</b>秒之后自动跳转!';
        }
        if (! headers_sent()) {
            if (0 === $time) {
                header('Location: '.$url);
            } else {
                header('refresh:'.$time.';url='.$url);
                echo $msg;
            }
            exit();
        } else {
            $str = '<meta http-equiv="Refresh" content="'.$time.'";URL="'.$url.'">';
            if ($time != 0) {
                $str .= $msg;
            }
            exit($str);
        }
    }
}
