
$(document).ready(function() {
    function closeWindow() {
        var thisModalID = $('.close').parent().attr('id');
        $('#modalShade, #'+thisModalID).fadeOut();
        $('#modalShade, .close').remove();
    }

    function insertPic(element) {
        //$(element).prepend('');
    }

    $('a.modal').click(function() {
        var modalID = $(this).attr('rel');
        var modalFile = $(this).attr('href');
        var loadfile = 'views/index/' + modalFile;
        $('#' + modalID).load(loadfile).fadeIn();
        $('body').on('click', '.close', closeWindow);


        var modalMarginTop = ($('#' + modalID).height() + 80) / 2;
        var modalMarginLeft = ($('#' + modalID).width() + 80) / 2;

        $('#' + modalID).css({
            'margin-top' : -modalMarginTop,
            'margin-left' : -modalMarginLeft
        });

        $('body').append('<div id="modalShade"></div>');
        $('#modalShade').css('opacity', 0.7).fadeIn();
        return false;
    });
});
