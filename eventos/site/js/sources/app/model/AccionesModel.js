app.data.models.AccionesModel = app.models.Model.extend({
		name: 'AccionesModel',		
		estado:false,
		confirmado:0,
    	clean : function(){
    		this.unset('query', {silent:true});
    	},
    	setEstado : function(estado,idReserva){
    		console.log(estado,idReserva);
    		this.set('estado',true);
    		var self = this;
    		this.url.eventos.setReservaEstado({estado:estado,idReserva:idReserva},function(data){    	
    			location.reload();
    			return;
    			self.set('confirmado',data.estadoReserva);
    			self.set('estado',false);
    			//
    			if(data.estadoReserva == 0 || data.estadoReserva == 1 || data.estadoReserva == 2){
    				//location.reload();
    				
        			
    			}
    		});    		
    		//this.set('confirmado',estado);
    	}

});