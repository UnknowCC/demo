$(document).ready(function() {
	var flag = false;

	$('#form').submit(function(e) {
		e.preventDefault();
		if (flag) {return false;}
		$flag = true;
		$('#submit').val('Sending');
		$('span.error').remove();
		alert($(this).serialize());
		$.post('addMessage.php', $(this).serialize(), function(msg) {
			$flag = false;
			$('#submit').val('Post message');

			if (msg.status) {
				$(msg.html).hide().insertAfter('#main').slideDown();
				$('#content').val('');
			} else {
				$.each(msg.errors, function(k, v) {
					$('label[for='+k+']').append('<span class="error">'+v+'</span>');
				});
			}
		}, 'json');
	});
});
