(function($) {
	var cover, post, board, boardCover;
	
	$.uniprogy.cover = {
		init: function(){
			if(boardCover)
				return;
			boardCover = $("#wlt-BoardCoverIndex");
			cover = boardCover.find(".cover img:first");
			post = boardCover.find('input[name="MBoardCoverForm[postId]"]');
			board = boardCover.find('input[name="MBoardCoverForm[boardId]"]');
			prev = boardCover.find(".prev");
			next = boardCover.find(".next");
			
			prev.click(function(){
				$.uniprogy.cover.next(0,this);
			});

			next.click(function(){
				$.uniprogy.cover.next(1,this);
			});	
			
		},
		next: function(next, aButton){
			aButton.disabled = true;
			
			$.ajax({
				url: $.uniprogy.picture.settings.baseUrl + '/board/cover/post?next='+next+'&postId='+post.val()+'&boardId='+board.val(),
				dataType: 'json',
				success: function(data){
					if(data){
						$.uniprogy.cover.update(data.postId,data.src);						
					}
					aButton.disabled = false;
				}
			});

		},
		update: function(postId,src){
			if(postId)
				post.val(postId);
			if(src)
				cover.attr("src",src);
		}
		
	};
	
})(jQuery);

