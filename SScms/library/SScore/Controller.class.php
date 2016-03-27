<?php

namespace SScore;

use SScore\Registry;
/**
 * 控制器基类
 */
abstract class Controller
{
    protected $view = null;

    protected $config = array();

    public function __construct()
    {
        $this->view = Registry::instance('SScore\\View');
    }

    public function display($templateFile, $content)
    {
        $this->view->display($templateFile, $content);
    }

    public function assign($name, $value)
    {
        $this->view->assign($name, $value);
    }
}
