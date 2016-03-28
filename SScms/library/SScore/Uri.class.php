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

    public static function detect()
    {
        ob_start();
        $server = $_SERVER;
        $requestUri = ArrayHandle::get($server, 'PATH_INFO');
        $requestUri = explode('/', trim($requestUri, '/'));
        $controller = array_shift($requestUri) ?: 'index';
        $controller = '\\controller\\'.ucfirst(strtolower($controller)).'Controller';
        //echo (new $controller)->index();
        if (class_exists($controller)) {
            $reflectionController = new ReflectionClass($controller);
            $action = array_shift($requestUri) ?: 'index';
            if ($reflectionController->hasMethod(strtolower($action))) {
                $reflectionAction = $reflectionController->getMethod($action);
                 return $reflectionAction->invoke(new $controller());
            }
        } else {
            $reflectionAction = new ReflectionMethod('\\controller\\IndexController', 'wrong');
            return $reflectionAction->invoke(null);

        }
    }
}
