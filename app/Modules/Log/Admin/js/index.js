Ext.application
( 
	{
	name: 'Log',
	id: "Log",
	
	appFolder: 'engine/app/Modules/Log/admin/js',
	views: ["Panel", "LogGrid"],
	controllers: ['Log'],
	
	extend: "Admin.view.ux.Application"
	}
);