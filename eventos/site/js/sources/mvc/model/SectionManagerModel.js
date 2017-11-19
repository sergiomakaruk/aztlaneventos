app.models.SectionManagerModel = app.models.HashModel.extend({
	name: 'sectionManagerModel',
	sections:[],
	sname:'',//currentSectionName
	section:null,//currentSection
	registerSections : function(section, name) {
		this.sections[name]=section;
		section.onRegister();
	},
	hashChange:function(sname,route,params)
	{
		if(sname == this.sname)
			{
				if(this.section.model){					
					this.section.model.set('query',{route:route,params:params});
				}
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
		if(route && this.section.model){			
			this.section.model.set('query',{route:route,params:params});
		}
		this.section.show();
	}
});