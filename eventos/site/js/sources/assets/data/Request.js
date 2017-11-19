(function(app) {

	app.data.Request = {
		unserialize : function(data) {
			//return data;
			//return JSON.parse(data);
			return JSON.parse($.base64.decode(data));
		},
		serialize : function(params) {

			params = params || [];

			var r = [], p = {};

			if (typeof params.length != 'undefined') {
				for ( var x = 0; x < params.length; x++) {
					eval('p.' + params[x].name + '=params[x].value');
				}
			} else {
				p = params;
			}
			r.push({
				name : 'data',
				value : $.base64.encode(JSON.stringify(p))
			});
			/*r.push({
				name : 'token',
				value : FbContext.getToken()
			});*/
			return r;
		},

		post : function(params) {

			$.ajax({
				url : params.url,
				type : 'POST',
				dataType : 'json',
				data : app.data.Request.serialize(params.data),
				error : function() {
					hx.throwError(AppError.dataTransfer);
				},
				success : function(data) {

					if(app.application.encode64)d = app.data.Request.unserialize(data.data);
					else d = data;
					if (d.error == 0) {
						params.success(d.data);
					} else {
						// el servicio devuelve un error
						var e = {};
						e.errorCode = d.errorCode;
						e.errorMsg = d.errorMsg;
						app.logger.log(e);
					//	hx.throwError(e);
					}
				}
			});

		},
		upload : function(params) {

			var formData = new FormData();
			$(params.form.find(':file')).each(function() {
				formData.append($(this).attr('name'), this.files[0]);
			});

			var p = [];
			for ( var x = 0; x < params.form.serializeArray().length; x++) {
				p.push(params.form.serializeArray()[x]);
			}

			var data = app.data.Request.serialize(p);
			for ( var x = 0; x < data.length; x++) {
				formData.append(data[x].name, data[x].value);
			}

			$.ajax({
				url : params.url,
				type : 'POST',
				dataType : 'json',
				cache : params.cache || false,
				contentType : params.contentType || false,
				processData : params.processData || false,

				data : formData,
				error : function() {
					hx.throwError(AppError.dataTransfer);
				},
				progress : params.progress || function() {
				},
				xhr : function() {
					myXhr = $.ajaxSettings.xhr();
					if (myXhr.upload) {
						myXhr.upload.addEventListener('progress', params.progress, false);
					}
					return myXhr;
				},
				success : function(data) {
					d = app.data.Request.unserialize(data.data);
					if (d.error == 0) {
						params.success(d.data);
					} else {
						// el servicio devuelve un error
						var e = {};
						e.errorCode = d.errorCode;
						e.errorMsg = d.errorMsg;
						hx.throwError(e);
					}
				}
			});

		}
	};

})(window.app);
