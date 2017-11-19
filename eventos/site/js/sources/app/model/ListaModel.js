app.data.models.ListaModel = app.models.SectionModel.extend({
		name: 'ListaModel',
		evento:null,
		reservas:null,
		resolveQuery : function(query) {
			this.getReservas(query.route[0]);
			this.getEvento(query.route[0]);
		}
		,
    	getEvento : function(idEvento){
    		var $self = this;
    		this.url.eventos.getEvento(idEvento,function(data){
    			$self.set('evento',data.evento);    			
    		});
    	},
    	getReservas : function(idEvento){
    		var $self = this;
    		this.url.eventos.getReservas(idEvento,function(data){    			
    			$self.set('reservas',data.reservas);
    		});
    	}, 
    	presentismo : function(obj,idEvento){
    		var $self = this;
    		this.url.eventos.presentismo(obj,function(data){    			
    			Url.setHash('#/ver-asistencia/'+idEvento);
    		});
    	}, 
    	clean : function(){
    		this.unset('query', {silent:true});
    	}

});