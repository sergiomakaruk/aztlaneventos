app.view.Lista = app.Section.extend({
	el:'div#lista',
	template:null,
	btns:null,
	initialize: function() {
		var ui = $(this.el);
		this.model = new app.data.models.ListaModel();
		this.model.onRegister();
		this.listenTo(this.model, "change:evento", this.renderEvento);
		this.listenTo(this.model, "change:reservas", this.renderReservas);
		this.template = $('body').find('div.evento-template').clone();
		this.template.show();
		this.template.removeClass('evento-template');
		this.template.find('.btn-lista').parent().remove();
		this.template.find('.btn-links').parent().remove();

		this.template.addClass('evento');

		this.btns = $('body').find('div.template-btn').clone();
		this.btns.show();
		this.btns.removeClass('template-btn');
		this.btns.remove();
	},

	renderReservas : function(){
		var reservas = this.model.get('reservas');
		reservas = _.sortBy(reservas, function(i) {return i.usuario.apellido.substring(0,1).toLowerCase()})
		var ui = $(this.el);
		var body = ui.find('tbody');
		body.empty();
		var tr,td,n,a;
		n=0;
		var self = this;
		$(reservas).each(function(){
			//log(this.confirmado);
		if(this.confirmado != 2){ // si no esta borrado
			n++;
			//log(this);
			tr = $('<tr data-estado='+this.confirmado+'>');
			if(this.usuario.admitido == 0)tr.addClass('no-admitido');
			body.append(tr);
			td = $('<td>');
			tr.append(td);
			td.text(n);
			td = $('<td>');
			tr.append(td);
			if(this.tipoUsuario == 1){
				a = $('<a href="#/usuario/'+this.usuario.idUsuario+'">');
				td.append(a);
				a.text(this.usuario.apellido + " " + this.usuario.nombre);
			}else{
				td.text(this.usuario.apellido + " " + this.usuario.nombre);
			}

//			td = $('<td>');
//			tr.append(td);
//			td.text(this.usuario.dni);
			td = $('<td>');
			tr.append(td);
			td.text(this.usuario.email);
//			td = $('<td>');
//			tr.append(td);
//			td.text(this.usuario.telefono);
			td = $('<td class="estado">');
			tr.append(td);
			//td.text(self.getEstado(this.confirmado));
			td = $('<td>');
			tr.append(td);
			td.text(this.cantLugares);
			td = $('<td>');
			tr.append(td);
			td.text(this.owner);
			td = $('<td>');
			tr.append(td);
			if(this.source != 0) td.text(eventos.getNameSource(this.source));
			else td.text(this.usuario.source);
			td = $('<td class="acciones">');
			tr.append(td);
			td.html(self.btns.clone());
			var buttons = new app.view.Acciones({el:tr,attributes:this});
			//buttons.attr('data-id-reserva',this.idReserva);

			}
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
	},
	hide : function(){
		$(this.el).hide();
		this.model.clean();
	}

});
