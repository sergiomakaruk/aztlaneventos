app.data.models.UsuarioModel = app.models.SectionModel.extend({
		name: 'UsuarioModel',
		usuario:null,
		resolveQuery : function(query) {
			this.getUsuario(query.route[0]);
		}
		,
    	getUsuario : function(id){
    		var $self = this;
				//log("ID",id);
    		this.url.eventos.getUsuario(id,function(data){
					//log(data);
    			$self.set('usuario',data.usuario);
    		});
    	},
			update: function(id,estado,txt,callback){
				var $self = this;
				//log("ID",id);
    		this.url.eventos.setUsuario(id,estado,txt,callback);
			},
    	clean : function(){
    		this.unset('query', {silent:true});
    	}

});
