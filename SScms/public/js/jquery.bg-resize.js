
(function($) {
    var containerObj, center = false;
    // 定义插件
    $.fn.bgResize = function(center) {
        center = center || false;

        containerObj = this;

        containerObj.css('visibility', 'hidden');

        $('body').css({
            'overflow-x': 'hidden';
        });
        $(window).load(function() {
            resizeImage();
        });

        $(window).bind('resize', function() {
            resizeImage();
        });
    };

    function resizeImage() {
        $('body').css({
            'overflow-x':'auto';
        });
        containerObj.css({
            'position':'fixed',
            'top':'0px',
            'left':'0px',
            'z-index':'-1',
            'overflow':'hidden',
            'width':getWindowWidth() + 'px',
            'height':getWindowHeight() + 'px'
        });

        var iw = containerObj.children('img').width();
        // 未完
    }
})
