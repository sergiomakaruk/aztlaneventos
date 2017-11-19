app.models.ModalModel = app.models.HashModel.extend({
	closepopup:false,
	opened:false,
	modal:null,
    hashChange: function(section,route){
		this.closepopup();
	},
	closepopup : function(){

		if(this.get('opened') == true){
			var modal = this.get('modal');
			this.set('opened',false);
			modal.modal('hide');
		}
	},
	setModal : function($modal){
		var self = this;
		this.register();//a partir de ahora toma el hash

		this.set('modal',$modal);
		$modal.modal();
		$modal.on('shown.bs.modal', function (e) {
			$modal.animate({ scrollTop: 0 }, 'slow');
			self.set('opened',true);
		});

		$modal.on('hidden.bs.modal', function (e) {
			 self.unregister();
			 self.onModalClosed();
		});
	},
	onModalClosed : function(){

	}

});