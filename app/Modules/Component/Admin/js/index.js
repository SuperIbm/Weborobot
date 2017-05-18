Ext.application
( 
	{
	name: 'Component',
	id: "Component",
	
	appFolder: 'app/Modules/Component/Admin/js',
	views: ["Panel"],
	controllers: ["Module", "Component"],
	
	extend: "Admin.view.ux.Application"
	}
);