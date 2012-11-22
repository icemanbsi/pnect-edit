(function($) {

$.uniprogy.picture.post = {
	s: {},
	
	init: function(settings)
	{
		$.uniprogy.picture.post.s = settings;		
	},
	
	validate: function(images,source)
	{
		var valid = [];
		var tmp = images.slice(0);
		var done = false;
		
		var validImage = function(img)
		{
			if(img.width >= $.uniprogy.picture.post.s.minWidth || img.height >= $.uniprogy.picture.post.s.minWidth)
				if($.inArray(img.src,valid)<0)
					valid.push(img.src);
			
			if(tmp.length && $.inArray(img.src,tmp)>=0)
				tmp.splice($.inArray(img.src, tmp), 1);
			
			if(tmp.length == 0 && !done)
			{
				done = true;
				$.uniprogy.picture.post.load(valid,source,true);
			}
		}
		
		var loadImage = function(src)
		{
			var img = new Image();
			img.src = src;
			img.onload = function()
			{
				validImage(img);
			}
			if(img.complete)
				validImage(img);
		}
		
		for(var i=0;i<images.length;i++)
 			loadImage(images[i]);
	},
	
	load: function(images,source,complete)
	{
		complete=complete?true:false;
		if(!complete && images.length > 0)
		{
			$('#wlt-PictureAdd').uWorklet().loading(true);
			$.uniprogy.picture.post.validate(images,source);
			return;
		}
		
		$('#wlt-PictureAdd').uWorklet().loading(false);
		$('#wlt-PictureAdd form').find(':input').removeAttr('disabled');
		
		if(images.length == 0)
		{
			alert($.uniprogy.picture.post.s.noImagesFound);
			return;
		}
		
		var form = $('.simpleSlide-tray[rel="picturePostSelect"]').closest('.worklet').find('form');
		$(form).find('input[name$="[imageUrl]"]').val(images[0]);

		$("#wlt-PicturePost").show();

		if(images.length <= 1)
			$("#wlt-PicturePost #selector .controls").hide();
		else
			$("#wlt-PicturePost #selector .controls").show();

		$('.simpleSlide-tray[rel="picturePostSelect"]').closest('.worklet')
			.find('form input[name$="[source]"]').val(source);

		$('.simpleSlide-tray[rel="picturePostSelect"]').html('');

		for(var i=0;i<images.length;i++)
			$('.simpleSlide-tray[rel="picturePostSelect"]').
				append('<div class="simpleSlide-slide" rel="picturePostSelect"><img src="'+images[i]+'" /></div>');

		$(document).ready(function(){
			simpleSlide({
				onSlide: function(img_no, rel_no){
					var images = $('.simpleSlide-window[rel="' + rel_no + '"]').find(".simpleSlide-slide");
					var img = images.eq(img_no).find("img");
					var form = img.closest(".worklet").find("form");
					$(form).find('input[name$="[imageUrl]"]').val(img.attr("src"));
				}
			});
		});
		
		if($.isFunction($.uniprogy.picture.post.s.onLoad))
			$.uniprogy.picture.post.s.onLoad();
	},
	
	disable: function()
	{
		$("#wlt-PicturePost").hide();
	}
}

})(jQuery);