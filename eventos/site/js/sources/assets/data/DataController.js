(function(app) {

	app.data.DataController = {

	eventos: {
		presentismo : function(obj,callback){
			var params = {
					url : '../services/eventos/setPresentismo/index.php',
					data: {presentismo:obj},
					success : function(data) {
						callback(app.data.PersistentData.parse(data));
					}
				};
				app.data.Request.post(params);
		},
		getUsuario : function(id,callback){
			var params = {
					url : '../services/eventos/getUsuario/index.php',
					data:{id: id},
					success : function(data) {
						callback(app.data.PersistentData.parse(data));
					}
				};
				app.data.Request.post(params);
		},
		setUsuario : function(id,estado,txt,callback){
			var params = {
					url : '../services/eventos/setUsuario/index.php',
					data:{id: id,estado:estado,txt:txt},
					success : function(data) {
						callback();
					}
				};
				app.data.Request.post(params);
		},
		getEventos : function(callback){
			var params = {
					url : '../services/eventos/getEventos/index.php',
					success : function(data) {
						callback(app.data.PersistentData.parse(data));
					}
				};
				app.data.Request.post(params);
		},
		getLatestsEventos : function(callback){
			var params = {
					url : '../services/eventos/getEventos/index.php',
					data:{latest: true},
					success : function(data) {
						callback(app.data.PersistentData.parse(data));
					}
				};
				app.data.Request.post(params);
		},
		buscar : function($txt,callback){
			var params = {
					url : '../services/eventos/getEventos/index.php',
					data:{search: $txt},
					success : function(data) {
						callback(app.data.PersistentData.parse(data));
					}
				};
				app.data.Request.post(params);
		},
		getEvento : function(idEvento,callback){
			var params = {
					url : '../services/eventos/getEvento/index.php',
					data: {idEvento:idEvento},
					success : function(data) {
						callback(app.data.PersistentData.parse(data));
					}
				};
				app.data.Request.post(params);
		},
		getReservas : function(idEvento,callback){
			var params = {
					url : '../services/eventos/getReservas/index.php',
					data: {idEvento:idEvento},
					success : function(data) {
						callback(app.data.PersistentData.parse(data));
					}
				};
				app.data.Request.post(params);
		},
		getOwners : function(callback){
			var params = {
					url : '../services/eventos/getOwners/index.php',
					success : function(data) {
						callback(app.data.PersistentData.parse(data));
					}
				};
				app.data.Request.post(params);
		},
		getSources : function(callback){
			var params = {
					url : '../services/eventos/getSources/index.php',
					success : function(data) {
						callback(app.data.PersistentData.parse(data));
					}
				};
				app.data.Request.post(params);
		},
		insert : function(parametros,callback){
			var params = {
					url : '../services/eventos/reservar/index.php',
					data: parametros,
					success : function(data) {
						callback(app.data.PersistentData.parse(data));
					}
				};
				app.data.Request.post(params);
		},
		setReservaEstado : function(parametros,callback){
			var params = {
					url : '../services/eventos/setReservaEstado/index.php',
					data: parametros,
					success : function(data) {
						callback(app.data.PersistentData.parse(data));
					}
				};
				app.data.Request.post(params);
		}
	},


};

})(window.app);
