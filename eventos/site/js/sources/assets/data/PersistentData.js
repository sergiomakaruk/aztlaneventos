(function(app) {


	app.data.PersistentData = {
		parse : function(data) {
			app.logger.log('PersistentData.parse', data);
			for ( var propertyName in data) {
				eval('app.data.PersistentData.' + propertyName + '=data.' + propertyName);
			}
			return data;

		}
	};

})(window.app);