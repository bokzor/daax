/**
 *
 */

(function(){
	window.location.urlVars = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
		window.location.urlVars[key] = value;
	});
})();

var Cookie={
	create:function(name,value,days){
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	},
	get:function(name){
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	},
	erase:function(name){
		Cookie.create(name,"",-1);
	}
};

RegExp.escape = function(text) {
    return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
};

Date.format=function(d,format){
	if(format!=null&&typeof(format)=="string"){
		var dt;
		return format.replace(/yyyy/g,d.getFullYear())
			.replace(/MM/g,(dt=d.getMonth()+1)<10?"0"+dt:dt)
			.replace(/dd/g,(dt=d.getDate())<10?"0"+dt:dt)
			.replace(/hh/g,(dt=d.getHours())<10?"0"+dt:dt)
			.replace(/mm/g,(dt=d.getMinutes())<10?"0"+dt:dt)
			.replace(/ss/g,(dt=d.getSeconds())<10?"0"+dt:dt);
	} else {
		return Date.format(d,"yyyy-MM-dd hh:mm:ss");
	}
};

JSON.clone=function(json){
	var copy={};
	for(var key in json){
		if(json.hasOwnProperty(key)){
			copy[key]=json[key];
		}
	}
	return copy;
};

Function.invoke=function(f){
	if(f!==undefined&&typeof(f)==='function'){
		var args=[];
		for (var i=1; i<arguments.length; i++){
			args.push(arguments[i]);
		}
		f.apply(null,args);
	}
};

function ens(str){
	if(str===undefined||str===null){
		return '';
	}
	return str;
};

function loadScript(url, callback){
    var script = document.createElement("script")
    script.type = "text/javascript";

    if (script.readyState){  //IE
        script.onreadystatechange = function(){
            if (script.readyState == "loaded" ||
                    script.readyState == "complete"){
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {  //Others
        script.onload = function(){
            callback();
        };
    }

    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
};

var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			prop: window.opera,
			identity: "Opera",
			versionSearch: "Version"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
		{
			   string: navigator.platform,
			   subString: "iPad",
			   identity: "iOS"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};


(function($){
	$.fn.popupWindow=function(option){
		option=$.extend({},$.fn.popupWindow.option,option);

		var winid;
		this.append(localize($('<div class="ui_window_wrap"><div class="modal_background"></div><div class="ui_window" id="'+(winid='uiw_'+($.fn.popupWindow._internalseq++))+'">'+option.html+'</div></div>')));

		var thisWin=$("#"+winid);
		var wrapper=thisWin.parent();
		var ag={opacity:1};

		var topfunc,orignalTop=(this.height()-thisWin.height())/2;
		if(option.top==null){
			topfunc=$.proxy(function(){
				return orignalTop;
			},this);
		}else if(typeof(option.top)==='function'){
			topfunc=function(){
				return option.top(orignalTop);
			};
		}else{
			topfunc=function(){
				return option.top;
			};
		}

		if(option.animate){
			if(option.fromElement!=null){
				ag['left']=(this.width()-thisWin.width())/2;
				ag['top']=topfunc();
				ag['width']=thisWin.width();
				ag['height']=thisWin.height();

				thisWin.width(option.fromElement.width());
				thisWin.height(option.fromElement.height());
				thisWin.offset(option.fromElement.offset());
			}else{
				thisWin.css({left:(this.width()-thisWin.width())/2,top:0});
			}
			$.proxy(option.beforeshow,wrapper)();
			thisWin.animate(ag,option.animateDuration,$.proxy(option.show,wrapper));
		}else{
			$.proxy(option.beforeshow,wrapper)();
			thisWin.css(ag);
			$.proxy(option.show,wrapper)();
		}

		if(option.dismissOnBlur){
			wrapper.children(".modal_background").click(function(event){
				wrapper.animate({opacity:0},300,function(){
					wrapper.remove();
				});
			});
		}
		return this;
	};

	$.fn.popupWindow.option={
		html:'',
		animate:true,
		animateDuration:250,
		fromElement:null,
		destroyOnClose:true,
		dismissOnBlur:true,
		top:null,
		show:function(){},
		beforeshow:function(){}
	};

	$.fn.popupWindow._internalseq=0;

	$.fn.unselectable=function(){
		this.css({'-moz-user-select':"none"}).attr('onselectstart','return false');
		return this;
	};

	$.fn.getCaretPosition = function() {
        var input = this.get(0);
        if (!input) return; // No (input) element found
        if ('selectionStart' in input) {
            // Standard-compliant browsers
            return input.selectionStart;
        } else if (document.selection) {
            // IE
            input.focus();
            var sel = document.selection.createRange();
            var selLen = document.selection.createRange().text.length;
            sel.moveStart('character', -input.value.length);
            return sel.text.length - selLen;
        }
    };
})(jQuery);