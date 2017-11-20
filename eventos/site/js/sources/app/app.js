
app.Router = Backbone.Router.extend({

	routes : {
		":query(/*params)" : "hashChange", // #search/kiwis/p7
		"" : "hashChange"
	},

	hashChange : function(section, url) {

		var route = [];
		var params;// = {};
		var hash;
		if (url)hash= url.split('?');

		if(hash && hash.length>1){
			eval('params={'
					+ hash[1].replace(/=/g, ':\'').replace(/&/g, '\',')
					+ '\'}');
		}
		if (hash)route = hash[0].split('/');

		if(section==undefined)section='dashboard';
		app.logger.log('ROUTER --> ',"S: ", section,"-R: ", route,"-P: ",params);
		app.Address.hashChange(section,route,params);

	}

});

var eventos = new app.data.models.EventosModel();


$(function() {

	if(isMobile.any())$('body').addClass('mobile');

	app.router = new app.Router();

	//Componentes solos
	new app.view.Menu({model:eventos});

	var sectionManagerModel = new app.models.SectionManagerModel();
	app.Address.register(sectionManagerModel);

	//secciones
	sectionManagerModel.registerSections(new app.view.Dashboard({model:eventos}), 'dashboard');
	sectionManagerModel.registerSections(new app.view.Lista(), 'lista');
	sectionManagerModel.registerSections(new app.view.ListaVerAsistencia(), 'ver-asistencia');
	sectionManagerModel.registerSections(new app.view.EditarAsistencia(), 'editar-asistencia');
	sectionManagerModel.registerSections(new app.view.Form(), 'form');
	sectionManagerModel.registerSections(new app.view.Login({model:eventos}), 'login');
	sectionManagerModel.registerSections(new app.view.Usuario(), 'usuario');

	eventos.bind('change',startSite);
	eventos.loadLatetst();
	$('.buscar').click(function(){
		eventos.buscar($('.buscador').val());
		Url.setHash('');
	});

	$( "form#target" ).submit(function( event ) {
  eventos.buscar($('.buscador').val());
  event.preventDefault();
	Url.setHash('');
});
	/*
$('.btn-ver-todos').click(function(){
	eventos.loadLatetst();
});
$('.btn-ver-ultimos').click(function(){
	eventos.load();
});*/

});

function startSite(){

	eventos.unbind('change',startSite);
	eventos.getOwners();
	eventos.getSources();
	Backbone.history.start();
	log('start');
}
