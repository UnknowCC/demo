<?php

namespace SScore;

/**
 * 视图类
 */
class View
{
    protected $templateVar = array();

    public function assign($name, $value = '')
    {
        if (is_array($name)) {
            $this->templateVar = array_merge($this->templateVar, $name);
        } elseif (! empty($value)) {
            ArrayHandle::set($this->templateVar, $name, $value)
        }
    }

    public function display($templateFile = '', $content = '')
    {
        $content = $this->fetch($templateFile, $content);
        $this->render($content);
    }


    private function fetch($templateFile = '', $content = '')
    {
        # code...
    }

    private function render($content)
    {
        header('Content-Type:text/html; charset=utf8' );
        header('Cache-control: private');
        echo $content;
    }
}
