(function($) {
	$(document).ready(function(){
		$('.comments .deleteLink, .comments .ajaxLink').live('click',function(){
			var listId = $(this).closest('.worklet').attr('id')+'-list';
			if($(this).hasClass('deleteLink'))
				$.fn.yiiListView.update(listId, {
					type:'POST',
					url:$(this).attr('href'),
					success:function() {
						$.fn.yiiListView.update(listId);
					}
				});
			return false;
		});
	});
})(jQuery);