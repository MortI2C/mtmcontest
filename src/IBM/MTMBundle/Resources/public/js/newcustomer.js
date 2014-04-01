define(['jquery', 'bootstrap'], function($, Boot) {
	$("form").attr('role','form');
	$("form div").each(function() {
		$(this).attr('class', 'form-group');
	});
	$("form div input, form div select").each(function() {
		$(this).attr('class','form-control');
	});
});

