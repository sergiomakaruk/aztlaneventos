Utils = {
		urlParams : function(url){
			if(url==null)url = window.location.href;			
			var params;			
			var hash= url.split('?');
			if(hash && hash.length>1){
				eval('params={'
						+ hash[1].replace(/=/g, ':\'').replace(/&/g, '\',')
						+ '\'}');
			}
			return params;
		},
		timestp : function(){
			return new Date().getTime();
		},
		resolveImgAlign : function(n){
			switch(Number(n)){
				case 0:return "img-left";
				case 1:return "img-middle";
				case 2:return "img-right";
				case 3:return "img-bottom";
				case 4:return "img-super-left";
				case 5:return "img-super-right";
			}
		},
		resolveRef : function(sectionType,ref)
		{
			var url="";
			switch(Number(sectionType))
			{
				case 1:url='home';break;
				case 2:url='article';break;
				case 3:url='pictures';break;
				case 4:url='videos';break;
				case 5:url='contact';break;
			}

			if(sectionType==2 || sectionType==4 || sectionType==5)
				{
					url+='/'+ref;
				}

			return '#/' + url;
		},

		db64ToText : function ($text)
		{
			return $.base64.decode($text);
		},

		db64ToPreviewText : function ($text,$cant)
		{
			return Utils.shortStr($.base64.decode($text),$cant);
		},

		shortStr : function($text,$cant){
			if(!$cant)$cant=1000;
			var dots = ($cant < $text.length) ? "..." : "";
			$cant = Math.min($cant,$text.length);
			return $text.substr(0,$cant)+dots;
		},
		shortArticle : function($text,$cant){
			if(!$cant)$cant=1000;
			var hasToShort = ($cant < $text.length) ? true : false;
			var dots = (hasToShort) ? "[...]" : "";
			$cant = Math.min($cant,$text.length);
			$text = $text.substr(0,$cant);
			/*$text = $text.split('</p>');
			$text.pop();
			$text = $text.join('</p>');*/
			return {short:hasToShort,text:$text+dots};
		},
		serialize : function(obj){
			return $.base64.encode(JSON.stringify(obj));
		},
		unserialize : function(data){
			return JSON.parse($.base64.decode(data));
		}

}

// static class Encode

function Encode() {
}

Encode.encode = function(t) {
	return t.replace(/[^a-z0-9_\/]+/gi, '_');
};

Encode.friendlyUrl = function(url) {
	url = '#!' + this.encode(url) + '.html';
	return url;
};
// end static class Encode


function Url(){}

Url.setHash = function($hash){
	window.location.hash = $hash;
};

Url.reload = function(){
	window.location = 'index.php';
};

Url.go = function(url){
	//log(window.location);return;
	window.location = url;
};
