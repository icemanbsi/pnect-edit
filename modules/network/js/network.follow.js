(function($) {
	$.uniprogy.networkFollow = {
		init: function()
		{
			$('.follow').live('click',function(){
				$.uniprogy.networkFollow.follow(this);
				return false;
			});
		},
		
		follow: function(link)
		{
			$.ajax({
				'type': 'post',
				'dataType': 'json',
				'url': $(link).attr('href'),
				'success': function(data){$(link).html(data.follow);}
			});
		}
	}
})(jQuery);