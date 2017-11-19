app.view.Menu = app.View.extend({
	el:'nav.nav-section',
	initialize: function() {
		var ui = $(this.el);
		var self = this;
		ui.find('.btn-actualizar').click(function(){
			self.model.load();
		});
	}

});
