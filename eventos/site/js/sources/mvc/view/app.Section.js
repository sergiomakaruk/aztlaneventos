app.Section = app.View.extend({
	onRegister: function(){
		$(this.el).hide();
	},
	show : function() {
		$(this.el).show();
	},
	hide : function() {
		$(this.el).hide();
	}
});