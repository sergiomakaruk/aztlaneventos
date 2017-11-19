/*app.viewController = {
	sections:[],
	sname:'',//currentSectionName
	section:null,//currentSection
	registerSections : function(view, name) {
		this.sections[name]=view;
		view.onRegister();
	},
	hashChange:function(sname,route)
	{
		if(sname == this.sname)
			{
				this.section.resolveHash(route);
				return;
			}

		if(this.sections[sname]==undefined)
			{
				app.router.navigate('error');
				sname = 'error';
						//return;
			}

		if(this.section)this.section.hide();

		this.section = this.sections[sname];
		//console.log(this.views,sname,this.views[sname]);
		this.sname = sname;
		this.section.render();
		if(route)this.section.resolveHash(route);
		this.section.show();
	}
}

app.Address.register(app.viewController);
*/

//aca pueden llegar a ir los cargando en funcion del cambio de modelo
app.SectionManager = Backbone.View.extend({
	el : 'div#sections',
	initialize : function(){
		$(this.el).hide();
	},
	startSite : function(){
		$(this.el).show();
	}
});