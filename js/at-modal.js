(function($){
$(document).ready(function() {
	
	
	
	//target
	$('#wpbody').addClass('at-modal-target');
	
	var atModalOkHandler = function() {
		document.location = 'http://www.google.com';
	};
	
	var atModalCancelHandler = function() {
		$('.at-welcome-dialog').hide();
		$('.at-modal-target').removeClass('at-overlay');
	}
	
	if(typeof hasSet !== 'undefined' && hasSet) {
		
		$('.at-modal-trigger').click(function() {


			$('.at-modal-target').addClass('at-overlay');


			var dialog = $('.at-welcome-dialog');
			dialog.remove();
			$('.at-modal-target').append(dialog);

			var dialog = $('.at-welcome-dialog');
			dialog.remove();
			$('body').append(dialog);
			
			$('.at-welcome-dialog p').html('')
			
			$('.at-welcome-dialog').show();
			$('#at-welcome-dialog-cancel').click(atModalCancelHandler);
			//$('#at-welcome-dialog-ok').click(atModalOkHandler);
		});
		
		
	}

	
	
	//trigger
	$('.at-modal-trigger').click(function() {
		
		
		$('.at-modal-target').addClass('at-overlay');
		
		
		var dialog = $('.at-welcome-dialog');
		dialog.remove();
		$('.at-modal-target').append(dialog);
		
		var dialog = $('.at-welcome-dialog');
		dialog.remove();
		$('body').append(dialog);
		$('.at-welcome-dialog').show();
		$('#at-welcome-dialog-cancel').click(atModalCancelHandler);
		//$('#at-welcome-dialog-ok').click(atModalOkHandler);
	});
	
	
	
	
	
});
})(jQuery);

