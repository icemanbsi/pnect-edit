(function($) {
	$.fn.uGift = function(settings)
	{
		var form = this;
		
		form.find('#MPictureForm_message').keyup(function(){
			var regexp = new RegExp(settings.regexp,'i');
			var price = null;
			var slides = $(this).closest('.worklet').find('.simpleSlide-slide');
			
			if((price = regexp.exec($(this).val())) && (price = price[0]))
			{
				slides.each(function(){
					var slide = $(this);
					if(slide.hasClass('video'))
						return;
					
					if(!slide.hasClass('gift'))
						slide.addClass('gift').prepend('<strong class="card container"><strong class="price">'+price+'</strong></strong>');
					else
						slide.find('.card .price').html(price);	
				});
			}
			else
			{
				slides.find('strong').remove();
				slides.removeClass('gift');
			}
		});
	}
})(jQuery);