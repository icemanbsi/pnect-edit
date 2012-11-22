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
