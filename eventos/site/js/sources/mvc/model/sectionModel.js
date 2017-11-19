app.models.SectionModel = app.models.Model.extend({
    defaults: {
    	route:'',
    	params:'',
    	query:''
    },
    onRegister: function(){
		    /*this.on('change:route',function(){this.resolveHash(this.get('route'))});
		    this.on('change:params',function(){
		    	var params = this.get('params');
		    	this.resolveParams(params);		    	
		    	});*/
		    this.on('change:query',function(){this.resolveQuery(this.get('query'))});
	},
    resolveHash : function(route) {
		app.logger.log('app.models.SectionModel:resolveHash() ', route);
	},
	resolveParams : function(params) {
		app.logger.log('app.models.SectionModel:resolveParams() ', params);
	},
	resolveQuery : function(query) {
		app.logger.log('app.models.SectionModel:resolveQuery() ', query);
	}
});