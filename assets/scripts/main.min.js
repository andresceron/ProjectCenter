$( document ).ready(function() {
	    
	// Toggle icons on click
	function toggleChevron(e) {
	    $(e.target)
	        .prev('.panel-heading')
	        .find("i.indicator")
	        .toggleClass('fa-chevron-down fa-chevron-up');
	}
	$('.accordion-icons').on('hidden.bs.collapse', toggleChevron);
	$('.accordion-icons').on('shown.bs.collapse', toggleChevron);

	// Alert timeout
	$(".alert-fadeout").fadeTo(10000, 500).slideUp(500, function(){
    	$(".alert-fadeout").alert('close');
	});

    // ADD TASK
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".step-todo"); //Fields wrapper
    var add_button      = $(".add-task-btn"); //Add button ID
    var x = 1; //initlal text box count

    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if (x < max_fields) { //max input box allowed
            x++; //text box increment
            $(wrapper).append(
            '<div class="single-task">' +
                '<div class="col-xs-10 p0">' +
                    '<input type="text" name="txt_proj_todo[]" class="form-control" placeholder="Add new task to this project" />' +   
                '</div>' +
                '<div class="col-xs-2 mt15">' +
                    '<button class="btn btn-xs btn-danger remove-task-btn"><i class="fa fa-minus"></i></button>' +
                '</div>' +
            '</div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove-task-btn", function(e){ //user click on remove text
        e.preventDefault(); $(this).closest('.single-task').remove(); x--;
    });

    // NAVBAR TOGGLE
    $('.navbar-toggle').on('click', function(e){
        e.preventDefault;
        $( ".slide-menu" ).toggle( "slide", {direction:'right'}, 300);
    });

    // NAVBAR CLOSE
    $(document).on('click', function (e) {
        if ($(e.target).closest(".navbar-toggle").length === 0) {
            $(".slide-menu").effect('slide', { direction: 'right', mode: 'hide' }, 300);
        }
    });

});