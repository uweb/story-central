!function(a){a.fn.zclip=function(b){if("object"==typeof b&&!b.length){var c=a.extend({path:"ZeroClipboard.swf",copy:null,beforeCopy:null,afterCopy:null,clickAfter:!0,setHandCursor:!0,setCSSEffects:!0},b);return this.each(function(){var b=a(this);if(b.is(":visible")&&("string"==typeof c.copy||a.isFunction(c.copy))){ZeroClipboard.setMoviePath(c.path);var d=new ZeroClipboard.Client;a.isFunction(c.copy)&&b.bind("zClip_copy",c.copy),a.isFunction(c.beforeCopy)&&b.bind("zClip_beforeCopy",c.beforeCopy),a.isFunction(c.afterCopy)&&b.bind("zClip_afterCopy",c.afterCopy),d.setHandCursor(c.setHandCursor),d.setCSSEffects(c.setCSSEffects),d.addEventListener("mouseOver",function(a){b.trigger("mouseenter")}),d.addEventListener("mouseOut",function(a){b.trigger("mouseleave")}),d.addEventListener("mouseDown",function(e){b.trigger("mousedown"),d.setText(a.isFunction(c.copy)?b.triggerHandler("zClip_copy"):c.copy),a.isFunction(c.beforeCopy)&&b.trigger("zClip_beforeCopy")}),d.addEventListener("complete",function(d,e){a.isFunction(c.afterCopy)?b.trigger("zClip_afterCopy"):(e.length>500&&(e=e.substr(0,500)+"...\n\n("+(e.length-500)+" characters not shown)"),b.removeClass("hover"),alert("Copied text to clipboard:\n\n "+e)),c.clickAfter&&b.trigger("click")}),d.glue(b[0],b.parent()[0]),a(window).bind("load resize",function(){d.reposition()})}})}return"string"==typeof b?this.each(function(){var c=a(this);b=b.toLowerCase();var d=c.data("zclipId"),e=a("#"+d+".zclip");"remove"==b?(e.remove(),c.removeClass("active hover")):"hide"==b?(e.hide(),c.removeClass("active hover")):"show"==b&&e.show()}):void 0}}(jQuery);var ZeroClipboard={version:"1.0.7",clients:{},moviePath:"ZeroClipboard.swf",nextId:1,$:function(a){return"string"==typeof a&&(a=document.getElementById(a)),a.addClass||(a.hide=function(){this.style.display="none"},a.show=function(){this.style.display=""},a.addClass=function(a){this.removeClass(a),this.className+=" "+a},a.removeClass=function(a){for(var b=this.className.split(/\s+/),c=-1,d=0;d<b.length;d++)b[d]==a&&(c=d,d=b.length);return c>-1&&(b.splice(c,1),this.className=b.join(" ")),this},a.hasClass=function(a){return!!this.className.match(new RegExp("\\s*"+a+"\\s*"))}),a},setMoviePath:function(a){this.moviePath=a},dispatch:function(a,b,c){var d=this.clients[a];d&&d.receiveEvent(b,c)},register:function(a,b){this.clients[a]=b},getDOMObjectPosition:function(a,b){var c={left:0,top:0,width:a.width?a.width:a.offsetWidth,height:a.height?a.height:a.offsetHeight};return a&&a!=b&&(c.left+=a.offsetLeft,c.top+=a.offsetTop),c},Client:function(a){this.handlers={},this.id=ZeroClipboard.nextId++,this.movieId="ZeroClipboardMovie_"+this.id,ZeroClipboard.register(this.id,this),a&&this.glue(a)}};ZeroClipboard.Client.prototype={id:0,ready:!1,movie:null,clipText:"",handCursorEnabled:!0,cssEffects:!0,handlers:null,glue:function(a,b,c){this.domElement=ZeroClipboard.$(a);var d=99;this.domElement.style.zIndex&&(d=parseInt(this.domElement.style.zIndex,10)+1),"string"==typeof b?b=ZeroClipboard.$(b):"undefined"==typeof b&&(b=document.getElementsByTagName("body")[0]);var e=ZeroClipboard.getDOMObjectPosition(this.domElement,b);this.div=document.createElement("div"),this.div.className="zclip",this.div.id="zclip-"+this.movieId,$(this.domElement).data("zclipId","zclip-"+this.movieId);var f=this.div.style;if(f.position="absolute",f.left=""+e.left+"px",f.top=""+e.top+"px",f.width=""+e.width+"px",f.height=""+e.height+"px",f.zIndex=d,"object"==typeof c)for(addedStyle in c)f[addedStyle]=c[addedStyle];b.appendChild(this.div),this.div.innerHTML=this.getHTML(e.width,e.height)},getHTML:function(a,b){var c="",d="id="+this.id+"&width="+a+"&height="+b;if(navigator.userAgent.match(/MSIE/)){var e=location.href.match(/^https/i)?"https://":"http://";c+='<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="'+e+'download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="'+a+'" height="'+b+'" id="'+this.movieId+'" align="middle"><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="false" /><param name="movie" value="'+ZeroClipboard.moviePath+'" /><param name="loop" value="false" /><param name="menu" value="false" /><param name="quality" value="best" /><param name="bgcolor" value="#ffffff" /><param name="flashvars" value="'+d+'"/><param name="wmode" value="transparent"/></object>'}else c+='<embed id="'+this.movieId+'" src="'+ZeroClipboard.moviePath+'" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="'+a+'" height="'+b+'" name="'+this.movieId+'" align="middle" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="'+d+'" wmode="transparent" />';return c},hide:function(){this.div&&(this.div.style.left="-2000px")},show:function(){this.reposition()},destroy:function(){if(this.domElement&&this.div){this.hide(),this.div.innerHTML="";var a=document.getElementsByTagName("body")[0];try{a.removeChild(this.div)}catch(b){}this.domElement=null,this.div=null}},reposition:function(a){if(a&&(this.domElement=ZeroClipboard.$(a),this.domElement||this.hide()),this.domElement&&this.div){var b=ZeroClipboard.getDOMObjectPosition(this.domElement),c=this.div.style;c.left=""+b.left+"px",c.top=""+b.top+"px"}},setText:function(a){this.clipText=a,this.ready&&this.movie.setText(a)},addEventListener:function(a,b){a=a.toString().toLowerCase().replace(/^on/,""),this.handlers[a]||(this.handlers[a]=[]),this.handlers[a].push(b)},setHandCursor:function(a){this.handCursorEnabled=a,this.ready&&this.movie.setHandCursor(a)},setCSSEffects:function(a){this.cssEffects=!!a},receiveEvent:function(a,b){switch(a=a.toString().toLowerCase().replace(/^on/,"")){case"load":if(this.movie=document.getElementById(this.movieId),!this.movie){var c=this;return void setTimeout(function(){c.receiveEvent("load",null)},1)}if(!this.ready&&navigator.userAgent.match(/Firefox/)&&navigator.userAgent.match(/Windows/)){var c=this;return setTimeout(function(){c.receiveEvent("load",null)},100),void(this.ready=!0)}this.ready=!0;try{this.movie.setText(this.clipText)}catch(d){}try{this.movie.setHandCursor(this.handCursorEnabled)}catch(d){}break;case"mouseover":this.domElement&&this.cssEffects&&(this.domElement.addClass("hover"),this.recoverActive&&this.domElement.addClass("active"));break;case"mouseout":this.domElement&&this.cssEffects&&(this.recoverActive=!1,this.domElement.hasClass("active")&&(this.domElement.removeClass("active"),this.recoverActive=!0),this.domElement.removeClass("hover"));break;case"mousedown":this.domElement&&this.cssEffects&&this.domElement.addClass("active");break;case"mouseup":this.domElement&&this.cssEffects&&(this.domElement.removeClass("active"),this.recoverActive=!1)}if(this.handlers[a])for(var e=0,f=this.handlers[a].length;f>e;e++){var g=this.handlers[a][e];"function"==typeof g?g(this,b):"object"==typeof g&&2==g.length?g[0][g[1]](this,b):"string"==typeof g&&window[g](this,b)}}},$(document).ready(function(){var a=$(window),b=$("#blurred-background");a.scroll(function(c){var d=a.scrollTop();b.css("opacity",d/150>1?1:d/150)})});