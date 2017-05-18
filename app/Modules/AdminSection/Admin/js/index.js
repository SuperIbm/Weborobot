Ext.application
( 
	{
	extend: "Admin.view.ux.Application",
	
	name: 'AdminSection',
	id: "AdminSection",
	
	appFolder: 'engine/app/Modules/AdminSection/Admin/js',
	views: ["Panel"],
	controllers: ['AdminSection']
	}
);