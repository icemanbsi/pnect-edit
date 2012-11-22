/**
 * jQuery.ScrollTo - Easy element scrolling using jQuery.
 * Copyright (c) 2007-2009 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * Date: 5/25/2009
 * @author Ariel Flesler
 * @version 1.4.2
 *
 * http://flesler.blogspot.com/2007/10/jqueryscrollto.html
 */
;(function(d){var k=d.scrollTo=function(a,i,e){d(window).scrollTo(a,i,e)};k.defaults={axis:'xy',duration:parseFloat(d.fn.jquery)>=1.3?0:1};k.window=function(a){return d(window)._scrollable()};d.fn._scrollable=function(){return this.map(function(){var a=this,i=!a.nodeName||d.inArray(a.nodeName.toLowerCase(),['iframe','#document','html','body'])!=-1;if(!i)return a;var e=(a.contentWindow||a).document||a.ownerDocument||a;return d.browser.safari||e.compatMode=='BackCompat'?e.body:e.documentElement})};d.fn.scrollTo=function(n,j,b){if(typeof j=='object'){b=j;j=0}if(typeof b=='function')b={onAfter:b};if(n=='max')n=9e9;b=d.extend({},k.defaults,b);j=j||b.speed||b.duration;b.queue=b.queue&&b.axis.length>1;if(b.queue)j/=2;b.offset=p(b.offset);b.over=p(b.over);return this._scrollable().each(function(){var q=this,r=d(q),f=n,s,g={},u=r.is('html,body');switch(typeof f){case'number':case'string':if(/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(f)){f=p(f);break}f=d(f,this);case'object':if(f.is||f.style)s=(f=d(f)).offset()}d.each(b.axis.split(''),function(a,i){var e=i=='x'?'Left':'Top',h=e.toLowerCase(),c='scroll'+e,l=q[c],m=k.max(q,i);if(s){g[c]=s[h]+(u?0:l-r.offset()[h]);if(b.margin){g[c]-=parseInt(f.css('margin'+e))||0;g[c]-=parseInt(f.css('border'+e+'Width'))||0}g[c]+=b.offset[h]||0;if(b.over[h])g[c]+=f[i=='x'?'width':'height']()*b.over[h]}else{var o=f[h];g[c]=o.slice&&o.slice(-1)=='%'?parseFloat(o)/100*m:o}if(/^\d+$/.test(g[c]))g[c]=g[c]<=0?0:Math.min(g[c],m);if(!a&&b.queue){if(l!=g[c])t(b.onAfterFirst);delete g[c]}});t(b.onAfter);function t(a){r.animate(g,j,b.easing,a&&function(){a.call(this,n,b)})}}).end()};k.max=function(a,i){var e=i=='x'?'Width':'Height',h='scroll'+e;if(!d(a).is('html,body'))return a[h]-d(a)[e.toLowerCase()]();var c='client'+e,l=a.ownerDocument.documentElement,m=a.ownerDocument.body;return Math.max(l[h],m[h])-Math.min(l[c],m[c])};function p(a){return typeof a=='object'?a:{top:a,left:a}}})(jQuery);
jQuery(document).ready(function($) {
	$('.uLoad').live('click', function(e) {
		e.preventDefault();
		var worklet = $(this).attr('name');
		$('#'+worklet).uWorklet().load({url: $(this).attr('href')});
	});
	$('.uDialog').live('click', function(e) {
		e.preventDefault();
		$.uniprogy.dialog($(this).attr('href'));
	});
});
/**
 * jQuery UniProgy plugin file.
 *
 */

;(function($) {
	
$.fn.uWorklet = function() {
	var worklet = this;
	
	var plugin = {		
		load: function(options)
		{
			var defaultSettings = {
				url: false,
				position: 'replace',
				success: false,
				showLoading: true
			}
			var settings = $.extend(defaultSettings,options);
			if(settings.showLoading)
				plugin.loading(true);
			$.ajax({
				url: settings.url,
				success: function(data) {
					var vars = {};
					vars[settings.position] = data;
					plugin.process({content:vars});
					plugin.loading(false);
					if($.isFunction(settings.success))
						settings.success(data);
				}
			});
			return worklet;
		},
		
		process: function(data)
		{
			if(data.redirect) { 
				if(data.redirectDelay)
					setTimeout('window.location = "'+data.redirect+'";', data.redirectDelay);
				else
					window.location = data.redirect;
				delete data.redirect;
			}
			if(data.info) { plugin.pushContent('.worklet-info:first', data.info); delete data.info; }
			if(data.content) { plugin.pushContent('.worklet-content:first', data.content); delete data.content; }
			if(data.load) {
				var target = data.load.target ? $(data.load.target) : worklet.find('.worklet-content:first');
				var url = data.load.url ? data.load.url : data.load;
				target.load(url);
				delete data.load;
			}
			
			for(var item in data) {
				if($.isPlainObject(data[item])) {
					var nWorklet = data[item].worklet ? $(data[item].worklet) : worklet;
					nWorklet.uWorklet().process(data[item]);
				}
			}
			return worklet;
		},
		
		pushContent: function(target, data)
		{
			target = worklet.find(target);
			if(!$.isPlainObject(data))
				target.html(data).show();
			else {			
				if(data.prependReplace) {
					target.find('.worklet-pushed-content.prepended').remove();
					data.prepend = data.prependReplace;
				}
				
				if(data.appendReplace) {
					target.find('.worklet-pushed-content.appended').remove();
					data.append = data.appendReplace;
				}
				
				var div = $('<div />');
				div.addClass('worklet-pushed-content');
				
				if(data.prepend)
					div.addClass('prepended').prependTo(target.show()).html(data.prepend);
				else if(data.append)
					div.addClass('appended').appendTo(target.show()).html(data.append);
				else if(data.replace)
					div.appendTo(target.html('').show()).html(data.replace);
					
				if(data.fade)
				{
					if(data.fade == 'target')
						target.animate({opacity: 1.0}, 3000).fadeOut("normal");
					else if(data.fade == 'content')
						div.animate({opacity: 1.0}, 3000).fadeOut("normal");
					else
						$(data.fade).animate({opacity: 1.0}, 3000).fadeOut("normal");
				}
				
				if(data.focus)
					$.scrollTo(target);
			}
			return worklet;
		},
		
		resetWorklet: function()
		{
			worklet.find('.worklet-info').hide();
			worklet.find('.worklet-content').show();
			plugin.resetContent();
			return worklet;
		},
		
		resetContent: function()
		{
			worklet.find('.worklet-pushed-content').remove();
			return worklet;
		},
		
		loading: function(on)
		{
			worklet.toggleClass('loading',on);
			return worklet;
		}
	};
	
	return plugin;
};

$.fn.uForm = function() {
	var form = $(this);
	var button;
	
	var plugin = {
		attach: function()
		{
			form.submit(function(e){
				e.preventDefault();
				form = $(this);
				plugin.submit();
			});
			form.find('input:submit').click(function(){
				button = $(this);
			});
			return form;
		},
	
		submit: function()
		{
			plugin.resetErrors();
			if(form.attr('enctype') == 'multipart/form-data')
				form.each(function(){
					this.submit();
				});
			else
			{
				if(typeof(CKEDITOR)!='undefined')
					for (instance in CKEDITOR.instances) 
					{
						var id = CKEDITOR.instances[instance].element.getId();
						if($('#'+id).length)
							CKEDITOR.instances[instance].updateElement();
					}
				var data = form.serialize();
				if(button)
					data+= '&'+button.attr('name')+'='+button.val();
				form.closest('.worklet').uWorklet().loading(true);			
				$.uniprogy.loadingButton(form.find('input[name="submit"]'),true);
				form.find(':input').attr('disabled',true);
				$.ajax({
					'type':'POST',
					'url':form.attr('action'),
					'cache':false,
					'data':data,
					'dataType':'json',
					'success': function(data) {
						if(!data.redirect && !data.keepDisabled)
							form.find(':input').removeAttr('disabled');
						form.closest('.worklet').uWorklet().loading(false);
						$.uniprogy.loadingButton(form.find('input[name="submit"]'),false);
						plugin.process(data);
					}
				});
			}
			return form;
		},
		
		process: function(data)
		{
			if(data.hideForm) form.hide();
			if(data.errors)	plugin.errorSummary(data.errors);
			form.closest('.worklet').uWorklet().process(data);
			return form;
		},
		
		errorSummary: function(data)
		{
			summary = form.find('.errorSummary');
			if(!summary)
				return;
	
			var content = '';
			for(var i=0;i<data.length;i++)
				content+= '<li>' + data[i].message + '</li>';
			summary.find('ul').html(content);
			summary.toggle(content!='');
			$.scrollTo(summary);
			return form;
		},
		
		resetErrors: function()
		{
			summary = form.find('.errorSummary');
			if(summary)
			{
				summary.find('ul').html('');
				summary.hide();
			}
			return form;
		},
		
		resetForm: function()
		{
			$.each(form,function(){
				this.reset();
			});
			plugin.resetErrors();
			form.show();
			form.parents('.worklet').uWorklet().resetWorklet();
			return form;
		}
	};
	return plugin;
}

$.uniprogy = {
	version : '1.1',
	dialogHidden: [],
	
	preloadImages: function(imgs)
	{
		$(imgs).each(function(){
			$('<img />')[0].src = this;
		});
	},
	
	loadingButton: function(button,on)
	{
		if(on) {
			var l = $('<div />').addClass('loading').css({display:'inline-block',width:'20px',height:'20px','vertical-align':'middle'});
			$(button).after(l);
		} else {
			$(button).next('.loading').remove();
		}
	},
	
	dialog: function(url)
	{
		$('#wlt-BaseDialog .content').load(url, function() {
			$('#wlt-BaseDialog .content').css({
					'max-height': $('#wlt-BaseDialog').dialog("option","maxHeight"),
					'overflow-y': 'auto'
			});
			var title = $('#wlt-BaseDialog .content .worklet-title');
			title.hide();
			$('#wlt-BaseDialog').dialog('option', 'title', title.html()); 
			$('#wlt-BaseDialog').dialog('open');
		});
	},
	
	dialogClose: function()
	{
		$('#wlt-BaseDialog').dialog('close');
	},
	
	ucfirst: function(str)
	{
		return str.substring(0, 1).toUpperCase() + str.substring(1).toLowerCase();
	},
	
	val: function(field,value)
	{
		if($(field).is(':radio'))
			$(field).val([value]);
		else
			$(field).val(value);
	}
};

})(jQuery);
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


(function($) {
	$.uniprogy.board = {
		init: function(data)
		{
			for(var i in data)
				$.uniprogy.board.addList(data[i],i);
			$(".removeList").live('click', function(){
				var id = $(this).closest("div").attr("id");
				id = id.substring(5);
				$.uniprogy.board.removeList(id);
			});
		},
		
		load: function()
		{
			var f = $("#username");
			if(f.val())
				$.ajax({
					url: f.closest('form').attr('action'),
					type: 'post',
					data: 'checkUsername='+escape(f.val()),
					dataType: 'json',
					success: function(data)
					{
						if(data.error)
							alert(data.error);
						else
						{
							f.val('');
							$.uniprogy.board.addList(data.username,data.id);	
						}
					}
				});
		},
		
		addList: function(label, value)
		{
			$('#selectedUsernames').append($.uniprogy.board.renderListView(label,value)).closest("form").append($.uniprogy.board.renderListField(value));
		},
		
		removeList: function(id)
		{
			$('#selectedUsernames').find("#list_"+id).remove();
			$('#selectedUsernames').closest("form").find('input[name="usernames['+id+']"]').remove();
		},
		
		renderListView: function(label, value)
		{
			var r = $('<div />').attr({'id':'list_'+value});
			r.html(label+' <a href="#" class="removeList">[x]</a> ');
			return r;
		},
		
		renderListField: function(value)
		{
			return $('<input type="hidden">').attr({'name':'usernames['+value+']','value':value});
		}
	};
})(jQuery);
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
(function($) {

$.fn.uLoc = function(data,selects) {
	var form = $(this);
	var data = data;
	
	form.find(':input[name$="[country]"]').change(function(){
		updateStates($(this).val(),1);
		return true;
	});
	
	form.find('select[name$="[state]"]').change(function(){
		updateCities(countryField().val(),$(this).val());
		return true;
	});
	
	var countryField = function()
	{
		return form.find(':input[name$="[country]"]');
	}
	
	var stateField = function()
	{
		return form.find('select[name$="[state]"]');
	}
	
	var cityField = function(type)
	{
		var cF = form.find(':input[name$="[city]"]');
			
		if(!cF.length)
			return false;
			
		if(type && (type.toUpperCase() != cF.get(0).tagName.toUpperCase()))
		{
			var id = cF.attr('id');
			var name = cF.attr('name');
			if(type == 'input')
				type+= ' type="text"';
			var newField = $('<'+type+' />').attr({'id': id, 'name': name});
			cF.after(newField).remove();
			return newField;
		}
		return cF;
	};
	
	var updateStates = function(country,uC)
	{
		var state = 0;
		if(data.states[country])
		{
			stateField().html('');
			var oneState = true;
			for(var i in data.states[country])
			{
				if(state===0)
					state = i;
				else
					oneState = false;
				$('<option />').attr('value',i).html(data.states[country][i]).appendTo(stateField());
			}
			if(oneState)
				stateField().parent().hide();
			else
				stateField().parent().show();
		}
		else
		{
			stateField().parent().hide();
		}
		if(uC)
			updateCities(country,state);
	}
	
	var updateCities = function(country,state)
	{
		if(!state)
			state = '0';
		var countryState = country+'_'+state;
		if(data.cities[countryState]===true || data.cities[country+'_*']===true)
		{
			var cF = cityField('input');
			if(cF)
				cF.parent().show();
		}
		else if(data.cities[countryState])
		{					
			var cF = cityField('select').html('');
			if(!cF)
				return;
			cF.parent().show().end();
			for(var i in data.cities[countryState])
			{
				$('<option />').attr('value',data.cities[countryState][i]).html(data.cities[countryState][i]).appendTo(cF);
			}
		}
		else
		{
			return cityField('input').parent().hide();
		}
	};
	
	if(!selects || !selects.country)
		updateStates(countryField().val(),1);
	else
	{
		countryField().val(selects.country);
		countryField().change();
		if(selects.state)
		{
			stateField().val(selects.state);
			stateField().change();
		}
		if(selects.city)
			cityField().val(selects.city);
	}
	return this;
}

})(jQuery);



var A = A || {};

/*--------------------------------------------------------------------------
  Anthe Specified Methods
/*------------------------------------------------------------------------*/

A.Anthe = {

  silentController: function() { // used to control the silent slider

    jQuery('ul.silent.slides').each(function(){
      var
        $s = jQuery(this),
        $p = $s.parent('.media-container'),
        $li = $p.siblings('.items').children(':not(.clear)'),
        $next = $p.siblings('.titles').children('.next'),
        $spans = $p.siblings('.titles').children('.span'),
        updActive = function($objs, c) { $objs.filter('.active').removeClass('active').end().eq(c).addClass('active'); },
        slide = function(i) { $s.siblings('.silent_tabs').children().eq(i).find('a').triggerHandler('click'); updLi(); },
        next = function() { $s.siblings('.silent_nav.next').click(); updLi(); },
        updId = function(id) { var f = id/4|0; return id-f }, // ignore every 4rd (li.clear)
        updLi = function() {
          var curSlide = $s.siblings('.silent_tabs').find('.silent_here').index();
          updActive($li,curSlide); 
          updActive($spans,curSlide);
        };

      $next.click(function(){ next(); return false; });
      $li.hover(function(){ slide(updId(jQuery(this).index())); }, function(){});
    });
  },

  processController: function() { // used to control the process titles
    jQuery('.items.process').each(function(){
      var
        $i = jQuery(this), $li = $i.children(),
        $spans = $i.siblings('.text-span.process').children(),
        updActive = function($objs, c) { $objs.filter('.active').removeClass('active').end().eq(c).addClass('active'); };
      $li.hover(function(){
        var cur = jQuery(this).index();
        updActive($li,cur);
        updActive($spans,cur);
      }, function(){});
    });
  },

  tuneMenu: function() { // used to stick menu on scroll
    var $h = jQuery('.head.top:not(.fix)'); if (!$h.length) return;
    var scrollTimeout, fixed = false, setA = this.activeMenu;
    windowH = jQuery(window).height();

    jQuery(window).scroll(function () {
      if (scrollTimeout) {
        // clear the timeout, if one is pending
        clearTimeout(scrollTimeout);
        scrollTimeout = null;
      }
      scrollTimeout = setTimeout(scrollHandler, 15);
    });

    scrollHandler = function () {
      var top = (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
      var safeZone = windowH - 10;
      if (!fixed && top > safeZone)
        { fixed = true; $h.addClass('fix'); }
      else if (fixed && top < safeZone)
        { fixed = false; $h.removeClass('fix'); }

      setA(top); // update active menu item
    };

    jQuery(window).resize(function(){ windowH = jQuery(window).height(); });
  },

  activeMenu: function(top) { // update active menu item

    if (!this.$sections) this.$sections = jQuery('.section'); // cache
    if (this.$sections.length < 2) return; // isn't a single page implementation

    if (!this.$top) { // cache
      this.$top = jQuery.map(jQuery('.head.top ol.menu li'), function(v,i){
        var $li = jQuery(v), $a = $li.find('a'), href = $a.attr('href');
        return [href,$li];
      });
      activeBefore = 1;
    };
    var map = this.$top;

    this.$sections.each(function(){
      var
        ridge = .45, $s = jQuery(this), t = ($s.position()).top, h = $s.height(),
        nextT = t + h, middleWindow = top + windowH*ridge;

      if (middleWindow > t && middleWindow < nextT) { // gotcha!
        for (i=0,l=map.length;i<l;i+=2) {
          if (map[i] == '#'+this.id) {
            map[activeBefore].removeClass('active');
            map[i+1].addClass('active'); activeBefore = i+1;
            break; }};
        return false; // break loop through the sections
      };
    });
  },

  autoLoad: function() {
    this.processController();
    this.silentController();
    this.tuneMenu();
  }
};

/*--------------------------------------------------------------------------
  User Interface Methods
/*------------------------------------------------------------------------*/

A.UserInterface = {

  tabs: function () {

    jQuery('.tabs').each(function() {

      var activeClass = 'active',
        $tabs = jQuery('> ul li', this),
        $content = jQuery('.tab', this);

      $tabs.click(function() {
        $tabs.removeClass(activeClass);
        jQuery(this).addClass(activeClass);
        $content.removeClass(activeClass);
        $content.eq(jQuery(this).index()).addClass(activeClass);
        return false;
      });
    });
  },

  
  
  contactForm: function() { // contact form client logic

    if (!jQuery('#contact').length) return;

    var
      errClass = 'err',
      $form = jQuery('#contact'),
      $msg = $form.find('textarea[name="msg"]'),
      msgDef = $msg.val(),
      $name = $form.find('input[name="name"]'),
      nameDef = $name.val(),
      $mail = $form.find('input[name="mail"]'),
      mailDef = $mail.val(),
      $send = $form.find('input[type="submit"]'),
      $submitAlt = jQuery('<a/>', { href: "#", text: $send.val(), 'class': '' });

    // prepare
    $msg.attr('rows', 1).elastic().blur();
    $send.replaceWith($submitAlt);

    // emulating placeholders
    var placeholder = function($obj,dflt) {
      $obj
        .val(dflt)
        .focus(function(){ if ($obj.val() == dflt) $obj.val(''); $obj.removeClass(errClass); })
        .blur(function(){ if (!$obj.val()) $obj.val(dflt); });
    };
    placeholder($name, nameDef);
    placeholder($mail, mailDef);
    placeholder($msg, msgDef);

    // click event
    $submitAlt.click(function(ev){
      ev.preventDefault();

      var
        error = false,
        noText = function(c,dflt){ if (c.jquery) c=c.val(); return !(jQuery.trim(c).length && c!=dflt) },
        noMail = function(c) { if (c.jquery) c=c.val(); return !(c.match(/[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}/)); };

      if (noText($msg,msgDef)) { $msg.addClass(errClass); error = true; }
      else $msg.removeClass(errClass);

      if (noText($name,nameDef)) { $name.addClass(errClass); error = true; }
      else $name.removeClass(errClass);

      if (noText($mail,mailDef) || noMail($mail)) { $mail.addClass(errClass); error = true; }
      else $mail.removeClass(errClass);
      
      if (error) return;
      
      $submitAlt.remove();
      jQuery.post($form.attr('action'), $form.serialize(), function (resp) {
          // resp = $(resp).find('#email-response').html();
          if (resp) $form.fadeOut(function () {
              $form.replaceWith(resp).fadeIn();
          });
      });
    });
  },

  mobileMenu: function() {
    var id = '#menu-list-mobile';
    if (!jQuery(id).length) return;

    jQuery(id).change(function(o) {
      var v = o.srcElement.value;
      if (v) window.location.href = v;
    });
  },

  autoLoad: function () {

    this.contactForm();
    this.mobileMenu();
    this.tabs();
  }
};

/*--------------------------------------------------------------------------
  Run 3rd-party jQuery Plugins
/*------------------------------------------------------------------------*/

A.JQueryPlugins = {

  autoLoad: function () {

    jQuery('a[href^="#"]').smoothScroll({ excludeWithin: ['.titles','.tabs'] });

    // fullscreen slider
    jQuery('ul.slides.full').responsiveSlides({
      auto: true,
      nav: false,
      pager: true,
      pauseControls: true,
      speed: 1300,
      timeout: 13000
    });

    // light slider (section#about)
    jQuery('ul.slides.light').responsiveSlides({
      auto: false,
      nav: true,
      pager: true,
      speed: 450
    });

    // silent slider (section#services & section#works)
    jQuery('ul.slides.silent').responsiveSlides({
      auto: false,
      nav: true,
      pager: true,
      speed: 10,
      namespace: 'silent'
    });

  }
};

/*--------------------------------------------------------------------------
  Google Map Wrapper
/*------------------------------------------------------------------------*/

A.GMap = {

  latitude: 51.508129,
  longitude: -0.128005,
  hue: '#3e3432',

  setup: function() {

    this.atts = this.$map.data();
    this.center = new google.maps.LatLng(this.atts.lat || this.latitude, this.atts.long || this.longitude);
    
    var opts = {
      center: this.center,
      disableDefaultUI: true,
      mapTypeId: google.maps.MapTypeId.TERRAIN,
      scrollwheel: false,
      zoom: 17
    };
    this.map = new google.maps.Map(this.$map[0], opts);
    
    var m = new google.maps.Marker({
        map: this.map,
        position: this.center,
        icon: new google.maps.MarkerImage('img/marker.png', new google.maps.Size(61, 61), new google.maps.Point(0, 0), new google.maps.Point(24, 54))});
    
    var s = [{ stylers: [{ hue: this.atts.hue || this.hue }, {saturation: -97}, {invert_lightness: true}, {visibility: 'simplified'}, {weight: 7}, {gamma: 1.5}] }];
    var t = new google.maps.StyledMapType(s, { name: 'Grayscale' });
    
    this.map.mapTypes.set('map', t);
    this.map.setMapTypeId('map');
  },

  onResize: function() {
    this.map && this.map.setCenter(this.center);
  },

  autoLoad: function() {

    this.$map = jQuery('#map');
    this.$map.length && this.setup();

    jQuery(window).resize(function(){ A.GMap.onResize(); });
  }
};

/*--------------------------------------------------------------------------
  Init jQuery & A Object
/*------------------------------------------------------------------------*/

; (function(){jQuery.noConflict();jQuery(document).ready(function(){for(var p in A)A.hasOwnProperty(p)&&A[p]&&A[p].autoLoad&&A[p].autoLoad()})})(jQuery);

/*--------------------------------------------------------------------------
  Packed 3rd-party jQuery Plugins
/*------------------------------------------------------------------------*/

// Custom easing
; jQuery.easing.jswing=jQuery.easing.swing;jQuery.extend(jQuery.easing,{def:'easeOut',swing:function(x,t,b,c,d){return jQuery.easing[jQuery.easing.def](x,t,b,c,d)},easeIn:function(x,t,b,c,d){return(!t)?b:c*Math.pow(2,10*(t/d-1))+b},easeOut:function(x,t,b,c,d){return(t==d)?b+c:c*(-Math.pow(2,-10*t/d)+1)+b},easeInOut:function(x,t,b,c,d){if(!t)return b;if(t==d)return b+c;if((t/=d/2)<1)return c/2*Math.pow(2,10*(t-1))+b;return c/2*(-Math.pow(2,-10*--t)+2)+b}});
// http://responsiveslides.com v1.32 by @viljamis
; (function(d,D,v){d.fn.responsiveSlides=function(h){var b=d.extend({auto:!0,speed:1E3,timeout:4E3,pager:!1,nav:!1,random:!1,pause:!1,pauseControls:!1,prevText:"Previous",nextText:"Next",maxwidth:"",controls:"",namespace:"rslides",before:function(){},after:function(){}},h);return this.each(function(){v++;var e=d(this),n,p,i,k,l,m=0,f=e.children(),w=f.size(),q=parseFloat(b.speed),x=parseFloat(b.timeout),r=parseFloat(b.maxwidth),c=b.namespace,g=c+v,y=c+"_nav "+g+"_nav",s=c+"_here",j=g+"_on",z=g+"_s",o=d("<ul class='"+c+"_tabs "+g+"_tabs' />"),A={"float":"left",position:"relative"},E={"float":"none",position:"absolute"},t=function(a){b.before();f.stop().fadeOut(q,function(){d(this).removeClass(j).css(E)}).eq(a).fadeIn(q,function(){d(this).addClass(j).css(A);b.after();m=a})};b.random&&(f.sort(function(){return Math.round(Math.random())-0.5}),e.empty().append(f));f.each(function(a){this.id=z+a});e.addClass(c+" "+g);h&&h.maxwidth&&e.css("max-width",r);f.hide().eq(0).addClass(j).css(A).show();if(1<f.size()){if(x<q+100)return;if(b.pager){var u=[];f.each(function(a){a=a+1;u=u+("<li><a href='#' class='"+z+a+"'>"+a+"</a></li>")});o.append(u);l=o.find("a");h.controls?d(b.controls).append(o):e.after(o);n=function(a){l.closest("li").removeClass(s).eq(a).addClass(s)}}b.auto&&(p=function(){k=setInterval(function(){f.stop(true,true);var a=m+1<w?m+1:0;b.pager&&n(a);t(a)},x)},p());i=function(){if(b.auto){clearInterval(k);p()}};b.pause&&e.hover(function(){clearInterval(k)},function(){i()});b.pager&&(l.bind("click",function(a){a.preventDefault();b.pauseControls||i();a=l.index(this);if(!(m===a||d("."+j+":animated").length)){n(a);t(a)}}).eq(0).closest("li").addClass(s),b.pauseControls&&l.hover(function(){clearInterval(k)},function(){i()}));if(b.nav){c="<a href='#' class='"+y+" prev'>"+b.prevText+"</a><a href='#' class='"+y+" next'>"+b.nextText+"</a>";h.controls?d(b.controls).append(c):e.after(c);var c=d("."+g+"_nav"),B=d("."+g+"_nav.prev");c.bind("click",function(a){a.preventDefault();if(!d("."+j+":animated").length){var c=f.index(d("."+j)),a=c-1,c=c+1<w?m+1:0;t(d(this)[0]===B[0]?a:c);b.pager&&n(d(this)[0]===B[0]?a:c);b.pauseControls||i()}});b.pauseControls&&c.hover(function(){clearInterval(k)},function(){i()})}}if("undefined"===typeof document.body.style.maxWidth&&h.maxwidth){var C=function(){e.css("width","100%");e.width()>r&&e.css("width",r)};C();d(D).bind("resize",function(){C()})}})}})(jQuery,this,0);
// Elastic by Jan Jarfalk unwrongest.com MIT License http://www.opensource.org/licenses/mit-license.php
; (function($){jQuery.fn.extend({elastic:function(){var g=['paddingTop','paddingRight','paddingBottom','paddingLeft','fontSize','lineHeight','fontFamily','width','fontWeight','border-top-width','border-right-width','border-bottom-width','border-left-width','borderTopStyle','borderTopColor','borderRightStyle','borderRightColor','borderBottomStyle','borderBottomColor','borderLeftStyle','borderLeftColor'];return this.each(function(){if(this.type!=='textarea'){return false}var f=jQuery(this),$twin=jQuery('<div />').css({'position':'absolute','display':'none','word-wrap':'break-word','white-space':'pre-wrap'}),lineHeight=parseInt(f.css('line-height'),10)||parseInt(f.css('font-size'),'10'),minheight=parseInt(f.css('height'),10)||lineHeight*3,maxheight=parseInt(f.css('max-height'),10)||Number.MAX_VALUE,goalheight=0;if(maxheight<0){maxheight=Number.MAX_VALUE}$twin.appendTo(f.parent());var i=g.length;while(i--){$twin.css(g[i].toString(),f.css(g[i].toString()))}function setTwinWidth(){var a=Math.floor(parseInt(f.width(),10));if($twin.width()!==a){$twin.css({'width':a+'px'});update(true)}}function setHeightAndOverflow(a,b){var c=Math.floor(parseInt(a,10));if(f.height()!==c){f.css({'height':c+'px','overflow':b})}}function update(a){var b=f.val().replace(/&/g,'&amp;').replace(/ {2}/g,'&nbsp;').replace(/<|>/g,'&gt;').replace(/\n/g,'<br />');var c=$twin.html().replace(/<br>/ig,'<br />');if(a||b+'&nbsp;'!==c){$twin.html(b+'&nbsp;');if(Math.abs($twin.height()+lineHeight-f.height())>3){var d=$twin.height()+lineHeight;if(d>=maxheight){setHeightAndOverflow(maxheight,'auto')}else if(d<=minheight){setHeightAndOverflow(minheight,'hidden')}else{setHeightAndOverflow(d,'hidden')}}}}f.css({'overflow':'hidden'});f.bind('keyup change cut paste',function(){update()});$(window).bind('resize',setTwinWidth);f.bind('resize',setTwinWidth);f.bind('update',update);f.bind('blur',function(){if($twin.height()<maxheight){if($twin.height()>minheight){f.height($twin.height())}else{f.height(minheight)}}});f.bind('input paste',function(e){setTimeout(update,250)});update()})}})})(jQuery);
// Smooth Scroll by Karl Swedberg; MIT, GPL
; (function(a){function f(a){return a.replace(/(:|\.)/g,"\\$1")}var b="1.4.7",c={exclude:[],excludeWithin:[],offset:0,direction:"top",scrollElement:null,scrollTarget:null,beforeScroll:function(){},afterScroll:function(){},easing:"swing",speed:400,autoCoefficent:2},d=function(b){var c=[],d=!1,e=b.dir&&b.dir=="left"?"scrollLeft":"scrollTop";return this.each(function(){if(this==document||this==window)return;var b=a(this);b[e]()>0?c.push(this):(b[e](1),d=b[e]()>0,d&&c.push(this),b[e](0))}),c.length||this.each(function(a){this.nodeName==="BODY"&&(c=[this])}),b.el==="first"&&c.length>1&&(c=[c[0]]),c},e="ontouchend"in document;a.fn.extend({scrollable:function(a){var b=d.call(this,{dir:a});return this.pushStack(b)},firstScrollable:function(a){var b=d.call(this,{el:"first",dir:a});return this.pushStack(b)},smoothScroll:function(b){b=b||{};var c=a.extend({},a.fn.smoothScroll.defaults,b),d=a.smoothScroll.filterPath(location.pathname);return this.unbind("click.smoothscroll").bind("click.smoothscroll",function(b){var e=this,g=a(this),h=c.exclude,i=c.excludeWithin,j=0,k=0,l=!0,m={},n=location.hostname===e.hostname||!e.hostname,o=c.scrollTarget||(a.smoothScroll.filterPath(e.pathname)||d)===d,p=f(e.hash);if(!c.scrollTarget&&(!n||!o||!p))l=!1;else{while(l&&j<h.length)g.is(f(h[j++]))&&(l=!1);while(l&&k<i.length)g.closest(i[k++]).length&&(l=!1)}l&&(b.preventDefault(),a.extend(m,c,{scrollTarget:c.scrollTarget||p,link:e}),a.smoothScroll(m))}),this}}),a.smoothScroll=function(b,c){var d,e,f,g,h=0,i="offset",j="scrollTop",k={},l={},m=[];typeof b=="number"?(d=a.fn.smoothScroll.defaults,f=b):(d=a.extend({},a.fn.smoothScroll.defaults,b||{}),d.scrollElement&&(i="position",d.scrollElement.css("position")=="static"&&d.scrollElement.css("position","relative"))),d=a.extend({link:null},d),j=d.direction=="left"?"scrollLeft":j,d.scrollElement?(e=d.scrollElement,h=e[j]()):e=a("html, body").firstScrollable(),d.beforeScroll.call(e,d),f=typeof b=="number"?b:c||a(d.scrollTarget)[i]()&&a(d.scrollTarget)[i]()[d.direction]||0,k[j]=f+h+d.offset,g=d.speed,g==="auto"&&(g=k[j]||e.scrollTop(),g=g/d.autoCoefficent),l={duration:g,easing:d.easing,complete:function(){d.afterScroll.call(d.link,d)}},d.step&&(l.step=d.step),e.length?e.stop().animate(k,l):d.afterScroll.call(d.link,d)},a.smoothScroll.version=b,a.smoothScroll.filterPath=function(a){return a.replace(/^\//,"").replace(/(index|default).[a-zA-Z]{3,4}$/,"").replace(/\/$/,"")},a.fn.smoothScroll.defaults=c})(jQuery);