Ext.application
( 
	{
	name: 'Module',
	id: "Module",
	
	appFolder: 'app/Modules/Module/admin/js',
	views: ["Panel"],
	controllers: ['Module'],
	
	extend: "Admin.view.ux.Application"
	}
);