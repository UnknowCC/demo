<?php

namespace controller;

use SScore\Controller;
/**
 *
 */
class IndexController extends Controller
{
    public function index()
    {
        $this->display();
    }

    public function login()
    {
        $this->display();
    }

    public static function wrong()
    {
        include (VIEW_PATH.'404.html');
    }
}
