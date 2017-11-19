app.view.EditarAsistencia = app.Section.extend({
	el:'div#lista-editar-asistencia',
	template:null,
	lastLine:null,	
	initialize: function() {
		var ui = $(this.el);		
		this.model = new app.data.models.ListaModel();
		this.model.onRegister();
		this.listenTo(this.model, "change:evento", this.renderEvento);
		this.listenTo(this.model, "change:reservas", this.renderReservas);
		this.template = $('body').find('div.evento-template').clone();
		this.template.show();
		this.template.removeClass('evento-template');
		this.template.find('.btn-lista').remove();
		this.template.find('.btn-editar').remove();
		this.template.find('.btn-form').remove();
		this.template.find('.btn-links').parent().remove();
		this.template.addClass('evento');	
		this.lastLine = $(this.el).find('.last-line');
		
		$.fn.bootstrapSwitch.defaults.onText = 'SI';
		$.fn.bootstrapSwitch.defaults.offText = 'NO';
	},
	
	renderReservas : function(){
		var reservas = this.model.get('reservas');
		reservas = _.sortBy(reservas, function(i) {return i.usuario.apellido.substring(0,1).toLowerCase()})
		var ui = $(this.el);
		var body = ui.find('tbody'); 
		body.empty();
		var tr,td,n;
		n=0;
		var self = this;
		var input,label,$totalPagos;
		$totalPagos = 0;
		$(reservas).each(function(){
			//log(this);
			//<th>Nombre y Apellido</th>			   	  
			// <th>Email</th>		         
			// <th>Presente</th>
			//<th>Lugares</th>
			//<th>Pago</th>
			// <th>Anotado</th>	
			
			if(this.confirmado != 2 ){ 
				n++;
				tr = $('<tr data-id="'+this.idReserva+'">');
				body.append(tr);
				td = $('<td>');
				tr.append(td);
				td.text(n);
				td = $('<td>');
				tr.append(td);
				td.text(this.usuario.apellido + " " + this.usuario.nombre);		
				td = $('<td>');
				tr.append(td);
				td.text(this.usuario.email);			
				td = $('<td class="presentismo">');
				tr.append(td);
				input = $('<input type="checkbox" name="radio-'+this.idReserva+'" value="0">');				
				if(this.asistencia == 1){
					input.prop('checked','true');
					input.prop('value','1');	
				}
				td.append(input);
				td = $('<td class=" text-center">');
				tr.append(td);
				input = $('<input type="number" class="form-control cant-input locked">');
				input.val(this.cantLugares);	
				td.append(input);
				td = $('<td class=" text-center">');
				tr.append(td);
				input = $('<input type="number" class="form-control cant-pago locked">');
				if(this.pago > 0) input.val(this.pago);
				else input.val(0);	

				$totalPagos = Number(Number($totalPagos) + Number(this.pago));
				if(this.asistencia == 0)input.val(0);					
				td.append(input);				
				td = $('<td class="altas-en-charlas text-center">');				
				tr.append(td);			
				input = $('<input class="locked" type="checkbox" name="radio-anotado-'+this.idReserva+'" value="0">');				
				if(this.anotado == 1){
					input.prop('checked','true');
					input.prop('value','1');	
				}
				td.append(input);

				if(this.asistencia == 0){
					tr.find('.locked').each(function(){
						$(this).attr('disabled','disabled');
						//console.log("LOG",this);
					});

				}	
				
				$("[name='radio-anotado-"+this.idReserva+"']").bootstrapSwitch();
				$("[name='radio-"+this.idReserva+"']").bootstrapSwitch();
				
				$("[name='radio-"+this.idReserva+"']").on('switchChange.bootstrapSwitch', function(event, state) {
					 // console.log(this); // DOM element
					  //console.log(event); // jQuery event
					 // console.log(state); // true | false
					  $(this).val((state) ? "1" : "0");
										
					if(state == false) 
					{
						$(this).parent().parent().parent().parent().find('.locked').each(function(){
							$(this).attr('disabled','disabled');							
						});
					}
					else 
					{					
						$(this).parent().parent().parent().parent().find('.locked').each(function(){
							$(this).prop('disabled','');							
						});
					}
					});

				$("[name='radio-anotado-"+this.idReserva+"']").on('switchChange.bootstrapSwitch', function(event, state) {
					 // console.log(this); // DOM element
					  //console.log(event); // jQuery event
					 // console.log(state); // true | false
					  $(this).val((state) ? "1" : "0");
					});
			};
			
			$('.btn-guardar').show();
			body.append(self.lastLine);
			$('td.total-pagos').html("$" + $totalPagos);
					
		});	
		
		$('.btn-guardar').click(function(){
			var evt = self.model.get('evento');
		
			$(this).hide();
			var obj = [];
			var ui = $(self.el);
			var body = ui.find('tbody'); 
			var trs = body.find('tr');
			trs.each(function(){
				var ob = {};
				ob.idReserva = $(this).attr('data-id');
				ob.presentismo = $(this).find('input[name=radio-'+ob.idReserva+']').val();
				ob.anotado = $(this).find('input[name=radio-anotado-'+ob.idReserva+']').val();
				ob.pago = $(this).find('input.cant-pago').val();
				ob.lugares = $(this).find('input.cant-input').val();
				if(ob.presentismo == 0){
					ob.pago = 0;
					//ob.lugares = null;
					//ob.anotado = 0;
				}
				if(ob.presentismo != null)obj.push(ob);
				
				//log(ob);
			});
			//return;
			//log(obj);
			self.model.presentismo(obj,evt.idEvento);
		});
	},
	renderEvento : function(){
		var evt = this.model.get('evento');
		log(evt);
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
