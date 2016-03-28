
$(document).ready(function() {
    $('a.modal').click(function() {
        var modalID = $(this).attr('rel');
        $('#'+modalID).fadeIn().prepend('<a href="#" class="close"><img src="public/images/close_button.png" class="close_button" title="Close Window" alt="Close" /></a>');

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

    $('a.close, #modalShade').live('click', function() {
        var thisModalID = $('a.close').parent().attr('id');
        $('#modalShade, #'.thisModalID).fadeOut(function() {
            $('#modalShade, a.close').remove();
        });
        return false;
    });

    $('#penewuser').blur(function() {
        var newName = $(this).val();
        $.post('peregister.php',
        {formName: 'register',
        penewuser: newName},
        function(data) {
            var usernameCount = data;
            if (1 == usernameCount) {
                $('#usernameError').css('display', 'inline');
            } else {
                $('#usernameError').css('display', 'none');
            }
        }, 'html');
    });
});
