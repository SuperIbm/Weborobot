Ext.application
( 
	{
	name: 'Widget',
	id: "Widget",
	
	appFolder: 'engine/app/Modules/Widget/admin/js',
	views: ["Panel"],
	controllers: ['Widget', 'WidgetCreate', 'WidgetUpdate'],
	
	extend: "Admin.view.ux.Application"
	}
);