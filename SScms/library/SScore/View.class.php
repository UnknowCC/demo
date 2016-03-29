<?php

namespace SScore;

use \ErrorException;

/**
 * 视图类
 */
class View
{
    private $templateExt = '.html';
    protected $templateVar = array();

    public function assign($name, $value = '')
    {
        if (is_array($name)) {
            $this->templateVar = array_merge($this->templateVar, $name);
        } elseif (! empty($value)) {
            ArrayHandle::set($this->templateVar, $name, $value);
        }
    }

    public function display($templateFile = '', $content = '')
    {
        $content = $this->fetch($templateFile, $content);
        $this->render($content);
    }


    private function fetch($templateFile = '', $content = '')
    {
        $templateFile = $this->parseTemplateFile($templateFile);

        if ($templateContent = file_get_contents($templateFile)) {
            return $templateContent;
        }
        // } else {
        //     throw new ErrorException('文件不存在或路径有误或无文件获取权限:'.$templateFile);
        // }
    }

    private function render($content)
    {
        header('Content-Type:text/html; charset=utf8' );
        header('Cache-control: private');
        echo $content;
    }


    private function parseTemplateFile($templateFile = '')
    {
        if (empty($templateFile)) {
            $modulePath = VIEW_PATH.trim(__CONTROLLER__, 'Controller').DS;
            $templateFile = $modulePath.__ACTION__.$this->templateExt;
        }
        //echo $templateFile;exit;
        return $templateFile;
    }
}
