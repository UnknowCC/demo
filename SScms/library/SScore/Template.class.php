<?php

namespace SScore;

use SScore\ArrayHandle;
/**
 * 自定义模板引擎
 */
class Template
{
    /**
     * 模板文件路径
     * @var string
     */
    public $templateDir = '';
    /**
     * 编译文件路径
     * @var string
     */
    public $compileDir = '';
    /**
     * 编译文件名前缀
     * @var string
     */
    public $compilePrefix = '';
    /**
     * 编译文件名后缀
     * @var string
     */
    public $compileExt = '';
    /**
     * 编译开始标识符
     * @var string
     */
    public $leftDelimiter = '<{';
        /**
         * 编译结束标记符
         * @var string
         */
    public $rightDelimiter = '}>';
    /**
     * 模板变量
     * @var array
     */
    private $templateVars = array();

    /**
     * 定义模板变量
     * @param  string|array $name  变量名或者变量数组
     * @param  string|null $value 变量值
     * @return void
     */
    public function assign($name, $value = '')
    {
        if (is_array($name)) {
            $this->templateVars = array_merge($this->templateVars, $name);
        } elseif ($value != '') {
            ArrayHandle::set($this->templateVars, $name, $value);
        }
    }

    /**
     * 加载模板文件并缓存文件
     * @param  string $fileName 模板文件名
     * @return  mixed
     */
    public function display($fileName)
    {
        $tplFile = $this->templateDir.DS.$fileName;
        if (! file_exists($tplFile)) {
            die('模板文件不存在:'.$tplFile);
        }
        $fileName = pathinfo($fileName, PATHINFO_FILENAME);
        $compileFile = $this->compileDir.DS.$this->compilePrefix.$fileName.$this->compileExt;

        if (! file_exists($compileFile) || filemtime($compileFile) < filemtime($tplFile)) {
            $reCompileContent = $this->tplReplace(file_get_contents($tplFile));

            $file_put_contents($compileFile, $reCompileContent);
        }
        include($compileFile);
    }

    /**
     * 模板变量解析
     * @param  string $content 模板文件内容
     * @return string
     */
    private function tplReplace($content)
    {
        /* 转义编译定界符 */
        $left = preg_quote($this->leftDelimiter, '/');
        $right = preg_quote($this->rightDelimiter, '/');

        /**
         * e 修饰符5.5弃用
         * preg_replace_callback_array() PHP 7
         */
        $pattern = array(
            /* 匹配变量标识 <{ $var }? */
            '/'.$left.'\s*\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*'.$right.'/i',
            /* 匹配 if 条件标识 <{ if $col == 'red' }> <{ /if }> */
            '/'.$left.'\s*if\s*(.+?)\s*'.$right.'(.+?)'.$left.'\s*\/if\s*'.$right.'/ies',
            /* 匹配 elseif 标识符 <{ elseif $col == 'red' }> */
            '/'.$left.'\s*else\s*if\s*(.+?)\s*'.$right.'/ies',
            /* 匹配 else 标识符 <{ else }> */
            '/'.$left.'\s*else\s*'.$right.'/is',
            /* 匹配 loop (循环数组值) 标识符 <{ loop $arrs $value }> <{ /loop } */
            '/'.$left.'\s*loop\s+\$(\S+)\s+\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*'.$right.'(.+?)'.$left.'\s+\/loop\s*'.$right.'/is',
            /* 匹配 loop (循环数组键和值) 标识符 <{ loop $arr $key => $value }> <{ /loop }> */
            '/'.$left.'\s*loop\s+\$(\S+)\s+\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*=>\s*\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*'.$right.'(.+?)'.$left.'\s*\/loop\s*'.$right.'/is',
            /* 匹配 include 标识符 <{ include 'header.html' }> */
            '/'.$left.'\s*include\s+[\(\'\"]?(.+?)[\)\'\"]?\s*'.$right.'/is'
        ),
        $replacement = array(
            '<?php echo $this->templateVars["${1}"]; ?>';
            '$this->stripvtages(\'<?php if(${1}) {?>\',\'${2}<?php } ?>\')',
            '$this->stripvtages(\'<?php } elseif (${1}) { ?>\', "")',
            '<?php } else { ?>',
            '<?php foreach ($this->templateVars["${1}"] as $this->templateVars["${2}"]) { ?>${3}<?php } ?>',
            '<?php foreach ($this->templateVars["${1}"] as $this->templateVars["${3}"] => $this->templateVars["${3}"]) { ?>${4}<?php } ?>',
            'file_get_contents($this->templateDir."/${1}")'
        );
        $replaceContent = preg_replace($pattern, $replacement, $content);
        if (preg_match('/'.$left.'([^('.$right.')]{1,})'.$right.'/', $replaceContent)) {
            $replaceContent = $this->tplReplace($replaceContent);
        }

        return $replaceContent;
    }

    /**
     * 替换条件语句 (if foreach) 中的变量
     * @param  string $express   条件或循环语句框架
     * @param  string $statement   语句执行或循环内容
     * @return string
     */
    private function stripvtages($express, $statement = '')
    {
        $valurPattern = '/\s*\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9\x7f-\xff]*)\s*/is';
        $express = preg_replace($valurPattern, '$this->templateVars["${1}"]', $express);
        $express = str_replace("\\\"", "\"", $express);
        $statement = str_replace("\\\"", "\"", $statement);
        return $express.$statement;
    }
}
