app.models.HashModel = app.models.Model.extend({
    	hashChange: function(section,route){
    		app.logger.log("hashModel hashChange,update");
    	},
    	register : function()
    	{
    		app.Address.register(this);
    	},
    	unregister : function()
    	{
    		app.Address.unregister(this);
    	}

});