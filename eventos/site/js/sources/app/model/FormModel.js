app.data.models.FormModel = app.models.SectionModel.extend({
		name: 'campPopupModel',
		evento:null,		
		resolveQuery : function(query) {			
			this.getEvento(query.route[0]);
		},
		getEvento : function(idEvento){
    		var $self = this;
    		this.url.eventos.getEvento(idEvento,function(data){
    			$self.set('evento',data.evento);    			
    		});
    	},    	
    	send : function(params){
    		
    		var self = this;

    		this.url.eventos.insert(params,function(data){    			
    			self.showTrueAlert();
    			var evento = self.get('evento')
    			Url.setHash('#/lista/'+evento.idEvento);
    		});
    		
    	},
    	showTrueAlert:function(){
    		toastr.options = {
    	    		  "closeButton": false,
    	    		  "debug": false,
    	    		  "positionClass": "toast-bottom-right",
    	    		  "onclick": null,
    	    		  "showDuration": "1000",
    	    		  "hideDuration": "1000",
    	    		  "timeOut": "15000",
    	    		  "extendedTimeOut": "15000",
    	    		  "showEasing": "swing",
    	    		  "hideEasing": "linear",
    	    		  "showMethod": "fadeIn",
    	    		  "hideMethod": "fadeOut"
    	    		}

    		//var camp = this.get('camp');
    		toastr.success("Tu reserva fue concretada", "");
    	}

});