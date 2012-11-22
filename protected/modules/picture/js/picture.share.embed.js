(function($) {

$.fn.uEmbed = function(aCode)
{
	var form = $(this);
	var code = aCode;

	var width = form.find('input[name$="[embedImageWidth]"]').val()*1;
	var height = form.find('input[name$="[embedImageHeight]"]').val()*1;
	var ratio = width / height;
	
	form.find('input[name$="[embedImageWidth]"]').keyup(function(){
		width = $(this).val();
		height = Math.round(width/ratio);
		$(this).closest('form').find('input[name$="[embedImageHeight]"]').val(height);
		update();
		return true;
	});
	
	form.find('input[name$="[embedImageHeigth]"]').keyup(function(){
		height = $(this).val();
		width = Math.round(height * ratio);
		$(this).closest('form').find('input[name$="[embedImageWidth]"]').val(width);
		return true;
	});
	
	form.find('textarea[name$="[embedHTMLCode]"]').focus(function(){
		$(this).select();
	});

	var update = function()
	{
		var str = code.replace("{width}",width,'g').replace("{width}",width,'g');
		str = str.replace("{height}",height,'g').replace("{height}",height,'g');;
		
		form.find('textarea[name$="[embedHTMLCode]"]').html(str);
	}
	update();
	form.find('textarea[name$="[embedHTMLCode]"]').focus();
}

})(jQuery);