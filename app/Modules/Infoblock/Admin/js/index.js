Ext.application
( 
	{
	name: 'Infoblock',
	id: "Infoblock",
	
	appFolder: 'engine/app/Modules/Infoblock/admin/js',
	views: ["Panel"],
	controllers: ['Infoblock'],

	locals: ["ru", "en"],
	
	extend: "Admin.view.ux.Application"
	}
);