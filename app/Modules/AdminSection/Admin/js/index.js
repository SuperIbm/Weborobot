Ext.application
( 
	{
	extend: "Admin.view.ux.Application",
	
	name: 'AdminSection',
	id: "AdminSection",
	
	appFolder: 'app/Modules/AdminSection/Admin/js',
	views: ["Panel"],
	controllers: ['AdminSection']
	}
);