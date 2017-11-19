app.view.Form = app.Section.extend({
	el:'div#form',
	template:null,
	initialize: function() {
		console.log('Iniciando..')
		var ui = $(this.el);		
		this.model = new app.data.models.FormModel();
		this.model.onRegister();
		this.listenTo(this.model, "change:evento", this.renderEvento);	
		this.listenTo(eventos, "change:owners", this.renderOwners);	
		this.listenTo(eventos, "change:sources", this.renderSources);	
		this.template = $('body').find('div.evento-template').clone();
		this.template.show();
		this.template.removeClass('evento-template');
		this.template.find('.btn-form').remove();
		this.template.addClass('evento');
		
		var self = this;
		ui.find("form").validate(Validation.validate(ui.find("form"),function(form){
			//log(form.addBase);return;
			if(form.addBase == null || form.addBase == undefined) form.addBase = 0;
			self.model.send(form);
			return false;
		}));
		
		$("[name='addBase']").bootstrapSwitch();
		$("[name='guardarEmail']").bootstrapSwitch();
		
		$("[name='addBase']").on('switchChange.bootstrapSwitch', function(event, state) {
			 
			$(this).val((state) ? "1" : "0");								
			if(state == false) 
			{
				ui.find("form").find('.locked').attr('disabled','disabled');			
			}
			else 
			{					
				ui.find("form").find('.locked').prop('disabled','');	
				
			}
		});
		
		$("[name='guardarEmail']").on('switchChange.bootstrapSwitch', function(event, state) {
			 
			$(this).val((state) ? "1" : "0");								
			if(state == false) 
			{
				ui.find("form").find('.locked').attr('disabled','disabled');			
			}
			else 
			{					
				ui.find("form").find('.locked').prop('disabled','');	
				
			}
		});
	},
	renderOwners : function(){
		var owners = eventos.get('owners');
		var selec = $(this.el).find('select#owner');
		var option;
		$(owners).each(function(){
			option = $('<option>'+this.nombre+'</option>');		
			option.attr('value',this.idOwner);
			selec.append(option);		
		});
	},
	renderSources: function(){
		var sources = eventos.get('sources');		
		var selec = $(this.el).find('select#fuente');
		var option;
		$(sources).each(function(){
			option = $('<option>'+this.nombre+'</option>');		
			option.attr('value',this.idFuente);
			selec.append(option);		
		});
	},
	renderEvento : function(){
		var evt = this.model.get('evento');
		var ui = $(this.el);
		ui.find('div.evento').remove();	
		var self = this;
		
		var evento = self.template.clone();		
		ui.prepend(evento);
		
		evento.find('.titulo').html(evt.titulo);
		evento.find('.subtitulo').html(evt.subtitulo);
		evento.find('.fecha').html(evt.fechaStr);
		evento.find('.lugar').html(evt.lugar);
		evento.find('.disponibilidad').html(evt.lugares);
		evento.find('.n-reservas').html(evt.reservas);
		evento.find('.confirmados').html(evt.confirmados);
		evento.find('.anotados').html(evt.anotados);
		evento.find('.asistencia').html(evt.asistencia);
		if(!self.user){
			//evento.find('.btn-form').hide();
			evento.find('.btn-links').hide();
		}		
		
		evento.find('.btn-volver').click(function(){
			window.history.back();
		});
		
		evento.find('.btn-lista').click(function(){
			Url.setHash('#/lista/'+evt.idEvento);
		});
		
		evento.find('.btn-form').click(function(){
			Url.setHash('#/form/'+evt.idEvento);
		});
		
		evento.find('.btn-ver').click(function(){
			Url.setHash('#/ver-asistencia/'+evt.idEvento);
		});
		
		evento.find('.btn-editar').click(function(){
			Url.setHash('#/editar-asistencia/'+evt.idEvento);
		});
		
		ui.find('input#tipo').val(evt.nombretipo);
		ui.find('input#idEvento').val(evt.idEvento);
	}
	

});
