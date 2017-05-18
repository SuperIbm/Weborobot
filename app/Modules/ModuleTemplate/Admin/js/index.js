Ext.application
( 
	{
	name: 'ModuleTemplate',
	id: "ModuleTemplate",
	
	appFolder: 'app/Modules/ModuleTemplate/Admin/js',
	views: ["Panel"],
	controllers: ["Module", "ModuleTemplate"],
	
	extend: "Admin.view.ux.Application"
	}
);