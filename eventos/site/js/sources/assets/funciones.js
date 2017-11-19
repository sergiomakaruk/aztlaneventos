//Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

function log(){

	if (!app.application.log)
		return;

	if(!arguments.length) console.API.clear();

	var e = 'console.log(\'Log->\',';

	for ( var x = 0; x < arguments.length; x++) {
		e += 'arguments[' + x + '],';
	}
	eval(e.replace(/,$/, ')'));
}

	if (typeof console._commandLineAPI !== 'undefined') {
	    console.API = console._commandLineAPI;
	} else if (typeof console._inspectorCommandLineAPI !== 'undefined') {
	    console.API = console._inspectorCommandLineAPI;
	} else if (typeof console.clear !== 'undefined') {
	    console.API = console;
	}


var isMobile = {
	    Android: function() {
	        return navigator.userAgent.match(/Android/i);
	    },
	    BlackBerry: function() {
	        return navigator.userAgent.match(/BlackBerry/i);
	    },
	    iOS: function() {
	        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	    },
	    Opera: function() {
	        return navigator.userAgent.match(/Opera Mini/i);
	    },
	    Windows: function() {
	        return navigator.userAgent.match(/IEMobile/i);
	    },
	    any: function() {
	        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	    }
	};

