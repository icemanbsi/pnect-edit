(function() {
	var popupUrl = '{popupUrl}';
	
	function isIE() {
        return /msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent);
    }
    function isChrome() {
        return /Chrome/.test(navigator.userAgent);
    }
    function isSafari() {
        return /Safari/.test(navigator.userAgent) && !isChrome();
    }
    function isIOS() {
        return navigator.userAgent.match(/iPad/i) != null || navigator.userAgent.match(/iPhone/i) != null || navigator.userAgent.match(/iPod/i) != null || navigator.userAgent.match(/iPod/i) != null
    }
	function in_array (needle, haystack, argStrict)
	{
		var key = '', strict = !!argStrict;

		if(strict)
			for(key in haystack)
				if(haystack[key] === needle)
					return true;
		else
			for(key in haystack)
				if(haystack[key] == needle)
					return true;
		
		return false;
	}

    if (window.location.href.match(/{baseUrlRegex}/))
	{
        alert('{alreadyInstalled}');
        return false;
    }
	
	if(!document.pnctRunning)
	{
		document.pnctRunning = true;
		var imgs = [];
		var srcs = [];
		var close = function(){}
		var hidden = [];
		
		{finder}
			
		if(imgs.length == 0)
		{
			alert('{noImagesFound}');
			document.pnctRunning = false;
			return false;
		}
		
		hide = function(tag)
		{
			var items = document.getElementsByTagName(tag);

			for (var i = 0; i < items.length; i++) {
				if (items[i].style.display != 'none') {
					hidden.push([items[i], items[i].style.display]);
					items[i].style.display = 'none';
				}
			}
		}
		
		unhide = function()
		{
			for (var i = 0; i < hidden.length; i++)
				hidden[i][0].style.display = hidden[i][1];

			hidden = [];
		}

		close = function(){
			overlay.parentNode.removeChild(overlay);
			container.parentNode.removeChild(container);
			unhide();
			document.pnctRunning = false;
			return false;
		}
		
		hide('embed');
		hide('iframe');
		hide('object');

		// writing style
		var s = '#pnctOverlay {position: fixed; z-index: 9999; top: 0; right: 0; bottom: 0; left: 0; background-color: #f2f2f2; opacity: .95;}';
		s+= '#pnctLogo {padding: 10px; text-align: center; background-color: #666;}';
		s+= '#pnctContainer {position: absolute; z-index: 9999; top: 0; left: 0; right: 0;}';
		s+= '#pnctCancelButton {display: block; line-height: 35px; background-color: #ccc; color: #666; text-align: center; font-weight: bold; text-decoration: none;}';
		s+= '#pnctCancelButton:hover {background-color: #e5e5e5;}';
		s+= '#pnctImagesContainer {margin-top: 15px;}';
		s+= '.pnctSpot {float: left; width: 190px; height: 190px; padding: 5px; border: 1px solid #d7d7d7; background-color: #fff; margin: 3px; position: relative; text-align: center;}';
		s+= '.pnctSpot a {display: block; width: 190px; height: 190px;}'
		s+= '.pnctSpot img {max-width: 190px; max-height: 190px;}';
		s+= '.pnctSpot .pnctPostButton {line-height: 24px; display: none; position: absolute; z-index: 99999; top: 50%; left: 50%; margin: -12px 0 0 -40px; width: 80px; height: 24px; border: none; background-color: #f2f2f2; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; color: #333; text-align: center; box-shadow: 0 0 2px #333;}';
		s+= '.pnctSpot .pnctImageDims {position: absolute; z-index: 99999; bottom:0; left: 65px; text-align: center; width: 60px; background-color: #fff; padding: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px;}';
		
		{style}

		var e=document.createElement("style");
		if(isIE()){
			e.type="text/css";
			e.media="screen";
			e.styleSheet.cssText=s;
			document.getElementsByTagName("head")[0].appendChild(e)
		}else{
			if(isSafari())
				e.innerText=s;
			else
				e.innerHTML=s;
			document.body.appendChild(e)
		}

		// overlay
		var overlay = document.createElement("div");
		overlay.setAttribute("id","pnctOverlay");
		document.body.appendChild(overlay);

		// container
		var container=document.createElement("div");
		container.setAttribute("id","pnctContainer");

		var html = '';
		// cancel button
		html+= '<a id="pnctCancelButton" href="#">{cancel}</a>';
		// logo
		html+= '<div id="pnctLogo">{logo}</div>';
		// images container
		html+= '<div id="pnctImagesContainer"></div>';

		container.innerHTML = html;
		document.body.appendChild(container);

		document.getElementById("pnctCancelButton").onclick=close;
		
		scroll(0,0);

		// images
		var imagesContainer = document.getElementById("pnctImagesContainer");
		for(var j=0;j<imgs.length;j++)
		{
			(function(img){

				var spot = document.createElement("div");
				spot.setAttribute("class","pnctSpot");
				spot.innerHTML = '<div class=\"pnctImageDims\">'+img.width+' x '+img.height+'</div>';
				
				var link = document.createElement("a");
				link.setAttribute("href","#");
				link.innerHTML = '<img src="'+img.src+'">';
				
				var button = document.createElement("div");
				button.setAttribute("class","pnctPostButton");
				button.innerHTML = '{postit}';
				
				if(isIE()){
					spot.attachEvent("onmouseover",function(){
						button.style.display="block";
					});
					spot.attachEvent("onmouseout",function(){
						button.style.display="none";
					})
				}else{
					spot.addEventListener("mouseover",function(){
						button.style.display="block";
					},false);
					spot.addEventListener("mouseout",function(){
						button.style.display="none";
					},false)
				}
				
				link.onclick=function()
				{
					window.open(popupUrl+'?image='+escape(img.src)+'&source='+escape(location.href),"pnct_"+(new Date).getTime(),"status=no,resizable=no,scrollbars=yes,personalbar=no,directories=no,location=no,toolbar=no,menubar=no,width=650,height=385,left=0,top=0");
					close();
					return false;
				}
				
				link.appendChild(button);
				spot.appendChild(link);
				
				{spot}
				
				imagesContainer.appendChild(spot);

			})(imgs[j]);
		}
	}
	
	
	
})();