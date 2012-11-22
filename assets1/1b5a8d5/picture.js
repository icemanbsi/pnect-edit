(function($) {
	$.uniprogy.picture = {
		settings:[], 
		init: function(s)
		{
			$.uniprogy.picture.settings = s;
			if (navigator.userAgent.indexOf("IE 8") == -1){
				$('.lightbox').live('click',function(){
					$.uniprogy.picture.lightbox(this);
					return false;
				});
			}

			if(s.isGuest)
				return;
			
			$('.like').live('click',function(){
				$.uniprogy.picture.like(this);
				return false;
			});
			
			$('.repost').live('click',function(){
				$.uniprogy.dialog($(this).attr('href'));
				return false;
			});
		},
		
		like: function(link)
		{
			$.ajax({
				'type': 'post',
				'dataType': 'json',
				'url': $(link).attr('href'),
				'success': function(data){
					$(link).html('<em></em>'+data.like);
				}
			});
		},
		
		lightbox: function(link)
		{
			var listId = $(link).closest('.worklet').attr('id')+'-list';
			var pageBody = document.getElementsByTagName('body')[0];			
			var lightbox = $.uniprogy.picture.CreateLightbox(pageBody);

			$(lightbox).load($(link).attr('href'), function() {});
			
			$(lightbox).hover(function() {
				pageBody.style.overflow = 'hidden';
			});
			
			$(pageBody).click(function(e)	{
				pageBody.style.overflow = 'hidden';
				if(e.target.className == "loaded"){
					$(lightbox).remove();
					pageBody.style.overflow = 'auto';
					$(pageBody).click(function(e){
						pageBody.style.overflow = 'auto';
					});
				}								
			});

		},
		
		CreateLightbox: function(pageBody){
			var lightbox = document.getElementById("lightbox");
			if (lightbox == null) {
				lightbox = document.createElement("div");
				lightbox.setAttribute("id", "lightbox");
				lightbox.setAttribute("class", "loaded");		
				pageBody.insertBefore(lightbox, pageBody.lastChild);
			}
			return lightbox;	
			

		}
		
	}
})(jQuery);