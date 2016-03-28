<!doctype html>
<html>
    <head>
        <style>
            /*
            *{border:1px solid red;height:20px}
            所有的HTML5结构标签本质上来说就是一个div标签，只不过有意义
            */
            /*页面头部 header*/
            header{height:150px;background:#ABCDEF}
            nav{height:30px;background:#ff9900;margin-top:100px}
            nav ul li{width:100px;height:30px;float:left;line-height:30px}
            /*页面中间 div */
            div{margin-top:10px;height:1000px;}
            section{height:1000px;background:#ABCDEF;width:70%;float:left}
            article{background:#F90;width:500px;margin:0 auto;text-align:center}

            aside{height:1000px;background:#ABCDEF;width:28%;float:right}
            /*页面底部 footer*/
            footer{height:100px;background:#ABCDEF;clear:both;margin-top:10px}
        </style>
    </head>
    <body>
        <header>
            <p>这是一个header标签</p>
            <nav>
                <ul>
                    <li>首页</li>
                    <li>起夜</li>
                    <li>论坛</li>
                    <li>商城</li>
                    <li>社区</li>
                </ul>
            </nav>
        </header>
        <div>

        <?php echo $content; ?>
        
        <footer>
            <p>这是一个footer标签</p>
            <hr />
            <small>法律条文</small>
            <small>联系我们</small>
            <small>客户意见</small>
            <small>商户合作</small>
        </footer>
    </body>

</html>
