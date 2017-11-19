(function(app) {

	function Logger() {
	}
	Logger.prototype.log = function() {
		if (!app.application.log)
			return;

		var e = 'console.log(\'Logger->\',';

		for ( var x = 0; x < arguments.length; x++) {
			e += 'arguments[' + x + '],';
		}
		eval(e.replace(/,$/, ')'));
	};

	app.logger = new Logger();

})(window.app);
