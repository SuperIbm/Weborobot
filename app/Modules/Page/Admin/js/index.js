Ext.application
(
	{
	name: 'Page',
	id: "Page",
	
	appFolder: 'engine/app/Modules/Page/admin/js',
	views: ["Panel"],
	controllers: ['Page', "PageCreate", "PageUpdate"],
	
	extend: "Admin.view.ux.Application"
	}
);