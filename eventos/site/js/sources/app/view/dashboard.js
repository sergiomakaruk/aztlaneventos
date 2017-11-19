app.view.Dashboard = app.Section.extend({
	el:'div#dashboard',
	template:null,
	thelink:null,
	currentEvt:null,
	initialize: function() {
		var self = this;
		var ui = $(this.el);
		this.listenTo(this.model, "change:eventos", this.renderEventos);
		this.listenTo(this.model, "change:user", this.renderEventos);
		this.template = ui.find('div.evento').clone();
		ui.find('div.evento').remove();		
		
		$('.modal select#fuente').change(function(){
			self.showLink(self)});
		
		$('.modal select#owner').change(function(){
			self.showLink(self)});		

		$('.view-link-csv').click(function(){
			Url.go('http://www.aztlan.com.ar/services/eventos/getCSVLinksInstructores/?idEvento='+self.currentEvt.idEvento);
		});
		
	},
	showLink:function(self){
		//console.log(self);
		var fuente = $('.modal select#fuente').val();
		var owner = $('.modal select#owner').val();
		if(fuente != null && owner != null){
			self.thelink = "http://www.aztlan.org.ar/pages/";
			if(self.currentEvt.tipoEvento_idTipo == 1)self.thelink+="cineclub"
			else self.thelink+="psi";
			
			self.thelink+="/?c="+self.currentEvt.idEvento+'/'+owner+'/'+fuente;
			$('.modal .view-link>input').val(self.thelink);
			$('.modal .link-resultado').show();
		}
	},
	renderOwners : function(){
		var owners = eventos.get('owners');
		var selec = $('.modal').find('select#owner');
		selec.empty();
		selec.append('<option>Instructor</option>');
		var option;
		$(owners).each(function(){
			option = $('<option>'+this.nombre+'</option>');		
			option.attr('value',this.idOwner);
			selec.append(option);		
		});
	},
	renderSources: function(){
		var sources = eventos.get('sources');		
		var selec = $('.modal').find('select#fuente');
		selec.empty();
		
		var option;
		$(sources).each(function(){
			option = $('<option>'+this.nombre+'</option>');		
			option.attr('value',this.idFuente);
			selec.append(option);		
		});
	},
	renderEventos : function(){
		var eventos = this.model.get('eventos');
		var ui = $(this.el);
		
		var cont = ui.find('.evt-container');
		cont.empty();
		var self = this;
		$(eventos).each(function(){
			//console.log(this);
			var evento = self.template.clone();
			var evt = this;
			cont.append(evento);
			//evento.attr('eid',evento.idEvento);
			evento.find('.titulo').html(this.titulo);
			evento.find('.subtitulo').html(this.subtitulo);
			evento.find('.fecha').html(this.fechaStr);
			evento.find('.lugar').html(this.lugar + " / " + this.direccion);
			evento.find('.disponibilidad').html(this.lugares);
			evento.find('.n-reservas').html(this.reservas);
			evento.find('.confirmados').html(this.confirmados);
			evento.find('.anotados').html(evt.anotados);
			evento.find('.asistencia').html(evt.asistencia);

			evento.find('.btn-links').click(function(){
				//console.log(evt);
				self.currentEvt = evt;
				//console.log(self.currentEvt);
				self.createModal();
				$('.modal').modal('show');
			});
			
			evento.find('.btn-ver').click(function(){
				Url.setHash('#/ver-asistencia/'+evt.idEvento);
			});
			
			evento.find('.btn-editar').click(function(){
				Url.setHash('#/editar-asistencia/'+evt.idEvento);
			});
			
			evento.find('.btn-lista').click(function(){
				Url.setHash('#/lista/'+evt.idEvento);
			});
			
			evento.find('.btn-form').click(function(){
				Url.setHash('#/form/'+evt.idEvento);
			});
			
			evento.find('.btn-edit-evento').click(function(){
				Url.go('crear/evento.php?idEvento='+evt.idEvento);
			});
			
			evento.find('.btn-descargar').click(function(){
				Url.go('http://www.aztlan.com.ar/services/eventos/getCSV/?idEvento='+evt.idEvento);
			});			
			
		});

	/*	
	lugar_idLugar
		"2"
		
	lugares
		"150"

		
	tipoEvento_idTipo
		"1"
	*/
	},
	createModal:function(){
		$('.modal .link-resultado').hide();
		$('.modal .view-link input').html('');
		this.renderOwners();
		this.renderSources();
	}

});
