app.view.Acciones = app.Section.extend({
	initialize: function() {
		var ui = $(this.el);		
		this.model = new app.data.models.AccionesModel();		
		this.listenTo(this.model, "change:estado", this.render);
		this.listenTo(this.model, "change:confirmado", this.changeEstado);
		
		var self = this;
		ui.find('.btn-estado').click(function(){
			if($(this).attr('data-estado')!=2)self.model.setEstado($(this).attr('data-estado'),self.attributes.idReserva);		
		});	 
		this.model.set('confirmado',self.attributes.confirmado);
		
		ui.find('.btn-usuario').popover({
			html:true,
			trigger:'hover',
			placement:'left',
			container:'body',					
			title:self.attributes.usuario.nombre + " " + self.attributes.usuario.apellido,
			content:'DNI:'+self.attributes.usuario.dni + '</br><span class="glyphicon glyphicon-phone-alt"></span> ' + self.attributes.usuario.telefono  + '</br> <span class="glyphicon glyphicon-envelope"></span> ' + self.attributes.usuario.email
		});
		
		var delet = $('<div class="btn-group"><button type="button" class="btn btn-default btn-ok">Confirmar</button><button type="button" class="btn btn-default btn-cancelar">Cancelar</button></div>');
		
		
		ui.find('.btn-estado.btn-borrar').popover({
			html:true,
			trigger:'click',
			placement:'left',								
			title:"¿Borrar " + self.attributes.usuario.nombre + " " + self.attributes.usuario.apellido + "?",
			content: delet
		});
		
		ui.find('.btn-estado.btn-borrar').on('shown.bs.popover', function () {
			delet.find('.btn-ok').click(function(){
				self.model.setEstado(2,self.attributes.idReserva);		
			});	
			
			delet.find('.btn-cancelar').click(function(){
				ui.find('.btn-estado.btn-borrar').popover('hide');				
				});	
			});		
		
	},
	getView : function(){return this.el},
	render : function(){

			var estado = this.model.get('estado');
			var ui = $(this.el);
			if(estado)ui.addClass('loading');
			else ui.removeClass('loading');		
	},
	changeEstado : function(){
		var ui = $(this.el);
		var e;
		switch(Number(this.model.get('confirmado')))
		{
			case 1:e='<span class="glyphicon glyphicon-ok"></span>';break;
			case 0:e='<span class="glyphicon glyphicon-remove"></span>';break;
			case 9:e='<span class="glyphicon glyphicon-phone-alt"></span>';break;
			case 8:e='<span class="glyphicon glyphicon-envelope"></span> ';break;
			case 2:e='<span class="glyphicon glyphicon-trash"></span>';
			//ui.addClass('hide');
			break;
		}		
		
		ui.find('.estado').html(e);		
	}

});
