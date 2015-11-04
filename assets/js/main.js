$( document ).ready(function() {
    
	// $('input').on('click', function(){
	//   var valeur = 0;
	//   $(':button').each(function(){
	//        if ( $(this).attr('value') > valeur )
	//        {
	//            valeur =  $(this).attr('value');
	//        }
	//   });
	//   $('.progress-bar').css('width', valeur+'%').attr('aria-valuenow', valeur);    
	// });


	$('.step-date').hide();

	if ($('.step-name').is(':visible')) {
		$('.btn-steps').on('click', function() {
			// $('.step-date').show();
			// $('.step-name').css('display', 'none');
			$('.step-date').css('display', 'block !important');
		});
	} else {
		console.log('not working');
	}



});