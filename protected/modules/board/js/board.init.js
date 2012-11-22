(function($) {
	$('.row').live('mouseover mouseout', function(event) {
		if (event.type == 'mouseover') {
			$(this).find(".removeBoard").show();
		} else {
			$(this).find(".removeBoard").hide();
		}
	});

	$(".removeBoard").live("click",function(){
		$(this).closest(".row").remove();
	});
})(jQuery);