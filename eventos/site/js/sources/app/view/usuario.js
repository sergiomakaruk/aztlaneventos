app.view.Usuario = app.Section.extend({
	el:'div#usuario-container',
	template:null,
	initialize: function() {
		var ui = $(this.el);
		this.model = new app.data.models.UsuarioModel();
		this.model.onRegister();
		this.listenTo(this.model, "change:usuario", this.renderUsuario);
		this.template = $('body').find('div.usuario-template').clone();
		this.template.show();
		this.template.removeClass('usuario-template');
		/*
		this.template.find('.btn-lista').parent().remove();
		this.template.find('.btn-ver').parent().remove();
		this.template.find('.btn-form').parent().remove();
		this.template.find('.btn-links').parent().remove();
		this.template.addClass('evento');
		*/
	},

	renderUsuario : function(){
		//log('hola');
		var usuario = this.model.get('usuario');
		var ui = $(this.el);
		//var body = ui.find('tbody');
		ui.empty();
		var tr,td,n;
		n=0;
		var self = this;
		var view = self.template.clone();
		ui.append(view);
		view.find('.nombre').text(usuario.nombre + " " + usuario.apellido);
		view.find('.email').text(usuario.email);
		view.find('.dni').text(usuario.dni);
		view.find('.telefono').text(usuario.telefono);
		view.find('.situacion').text(usuario.situacion);
		if(usuario.admitido_txt != null)view.find('.admitido_txt').text(usuario.admitido_txt);

		var radio = $("[name='radio-admitido']")

		if(usuario.admitido == 1){
			radio.prop('checked','true');
			radio.prop('value','1');
		}else{
			$('.motivo').show();
		}


		$("[name='radio-admitido']").bootstrapSwitch();

		$("[name='radio-admitido']").on('switchChange.bootstrapSwitch', function(event, state) {

				$(this).val((state) ? "1" : "0");
				usuario.admitido = (state) ? 1:0;
				if(state == false) $('.motivo').show();
				else $('.motivo').hide();
			});

		view.find('.user-actualizar').click(function(){
			var txt = view.find(".admitido_txt").val();
			//console.log(usuario.admitido);return;
			self.model.update(usuario.idUsuario,usuario.admitido,txt,function(){
				window.history.back();
			});

		});



		var cont = view.find('.eventos-user-container');
		var r,t,c;
		for (var variable in usuario.reservas) {
			r = usuario.reservas[variable];
			t = $('<tr>');
			c = $('<td class="date">');
			c.text(r.date);
			t.append(c);
			c = $('<td>');
			a = $('<a href="#ver-asistencia/'+r.idEvento+'">"');
			a.text(r.titulo);
			c.append(a);
			t.append(c);
			//c = $('<td>');
			c = $('<td class="presentismo">');
			//tr.append(c);
			if(r.asistencia && r.asistencia == 0)c.addClass('ausente');
			if(r.asistencia && r.asistencia == 1)c.addClass('presente');
			/*if(r.asistencia)c.text('Presente');
			else c.text('Ausente');*/
			t.append(c);
			cont.append(t);
		}
		$(this.el).show();
	},

	hide : function(){
		//
		$(this.el).hide();
		this.model.clean();
	}

});
