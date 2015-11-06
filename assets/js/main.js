$( document ).ready(function() {
	    
	function toggleChevron(e) {
	    $(e.target)
	        .prev('.panel-heading')
	        .find("i.indicator")
	        .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
	}
	$('.accordion-icons').on('hidden.bs.collapse', toggleChevron);
	$('.accordion-icons').on('shown.bs.collapse', toggleChevron);

});