define(['jquery', 'bootstrap'], function($, Boot) {

	var clickedOK = false;
	$(".confirm-form").on('submit', function(e) { if(!clickedOK) e.preventDefault(); });
	  $('#confirmDelete').on('show.bs.modal', function (e) {
		  $message = $(e.relatedTarget).attr('data-message');
	      $(this).find('.modal-body p').text($message);
	      $title = $(e.relatedTarget).attr('data-title');
	      $(this).find('.modal-title').text($title);

	      // Pass form reference to modal for submission on yes/ok
	      var form = $(e.relatedTarget).closest('form');
	      $(this).find('.modal-footer #confirm').data('form', form);
	  });

	  <!-- Form confirm (yes/ok) handler, submits form -->
	  $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
		  clickedOK = true;
	      $(this).data('form').submit();
	      clickedOK = false;
	  });
//	
//	return {
//		customerNew: function() {
//			return 'hello';
//		}
//	}
});

