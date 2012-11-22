(function($) {
	
	$(".pictureCommentAdd textarea").live("focus",function (){
		$(this).closest("form").find(".buttons").show();
		$(this).closest("form").find(".CommentLeft").show();
		if($("#wlt-PictureList").length<=0)
			$(this).closest("form").find(".hint").show();
		else
			$("#wlt-PictureList-list > .items").masonry("reload");			
	});
	
	$(".pictureCommentAdd textarea").live("keyup focus",function (){
		left = $.uniprogy.picture.settings['commentLength']*1 - $(this).val().length;
		commentLeft = $(this).closest("form").find(".CommentLeft");
		commentLeft.html(commentLeft.html().replace(/(\d+)/,left));
		
	});
	
})(jQuery);