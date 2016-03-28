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
        include (VIEW_PATH.'index/index.html');
    }

    public function login()
    {
        include (VIEW_PATH.'index/login.html');
    }

    public static function wrong()
    {
        include (VIEW_PATH.'404.html');
    }
}
