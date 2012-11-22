(function($) {
	$(document).ready(function(){
		$('.pictureCard').live('hover',function(){
			$(this).find('.pictureButtons').toggle();
		});
		$('#wlt-PictureList .pictureCommentAdd').live('submit', function(e){
			e.preventDefault();
			var form = $(this);
			var data = form.serialize();
			$.uniprogy.loadingButton(form.find('input[name="submit"]'),true);
			form.find(':input').attr('disabled',true);
			$.ajax({
				'type':'POST',
				'url':form.attr('action'),
				'cache':false,
				'data':data,
				'dataType':'json',
				'success': function(data) {
					$.uniprogy.loadingButton(form.find('input[name="submit"]'),false);
					form.find(':input').removeAttr('disabled');
					
					var list = form.closest('.pictureCard').find('.pictureComments > .worklet');
					if(list)
					{
						var listId = list.attr('id');
						var postId = listId.substr(listId.lastIndexOf('-')+1);
						$('#'+listId).yiiListView({'url':$.uniprogy.picture.settings.baseUrl+'/picture/comment/list?postId='+postId+'&listId='+listId,'ajaxUpdate':[listId],'ajaxVar':'ajax','pagerClass':'pager','loadingClass':'list-view-loading','sorterClass':'sorter','afterAjaxUpdate':function(){$("#wlt-PictureList-list > .items").masonry("reload");}});
						$.fn.yiiListView.update(listId);
					}
				}
			});
		});
	});
	$(window).scroll(function(){
		if($(window).scrollTop()>200 && !$('#wlt-PictureScroll').is(':visible'))
			$('#wlt-PictureScroll').fadeIn();
		else if($(window).scrollTop()<200 && $('#wlt-PictureScroll').is(':visible'))
			$('#wlt-PictureScroll').fadeOut();
	});
})(jQuery);