Ext.application
( 
	{
	name: 'Log',
	id: "Log",
	
	appFolder: 'app/Modules/Log/admin/js',
	views: ["Panel", "LogGrid"],
	controllers: ['Log'],
	
	extend: "Admin.view.ux.Application"
	}
);