$( document ).ready(function() {
	    
	// Toggle icons on click
	function toggleChevron(e) {
	    $(e.target)
	        .prev('.panel-heading')
	        .find("i.indicator")
	        .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
	}
	$('.accordion-icons').on('hidden.bs.collapse', toggleChevron);
	$('.accordion-icons').on('shown.bs.collapse', toggleChevron);

	// Alert timeout
	$(".alert-fadeout").fadeTo(10000, 500).slideUp(500, function(){
    	$(".alert-fadeout").alert('close');
	});
});