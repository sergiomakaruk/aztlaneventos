app.data.models.EventosModel = app.models.Model.extend({
		name: 'EventosModel',
		eventos:null,
		owners:null,
		sources:null,
		user:null,

		buscar: function($txt){
			console.log($txt);
			var $self = this;
			this.url.eventos.buscar($txt,function(data){
				$self.set('eventos',data.eventos);
			});
		},

    	login : function(obj){
    		var $self = this;
    		this.url.user.login(function(data){
    			$self.set('user',data.user);
    		});
    	},

    	load : function(obj){
    		var $self = this;
    		this.url.eventos.getEventos(function(data){
    			$self.set('eventos',data.eventos);
    		});
    	},
    	loadLatetst : function(obj){
    		var $self = this;
    		this.url.eventos.getLatestsEventos(function(data){
    			$self.set('eventos',data.eventos);
    		});
    	},
    	getOwners : function(){
    		var $self = this;
    		this.url.eventos.getOwners(function(data){
    			$self.set('owners',data.owners);
    		});
    	},
    	getSources : function(){
    		var $self = this;
    		this.url.eventos.getSources(function(data){
    			$self.set('sources',data.sources);
    		});
    	},
    	getNameSource : function(id){
    		var sources = this.get('sources');
    		$.each(sources,function(){
    			if(this.idFuente == id) {
    				sources = this.nombre;
    				return;
    			}
    		});
    		return sources;
    	}
});
