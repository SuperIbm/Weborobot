Ext.application
( 
	{
	name: 'PageTemplate',
	id: "PageTemplate",
	
	appFolder: 'engine/app/Modules/PageTemplate/Admin/js',
	views: ["Panel"],
	controllers: ['PageTemplate', 'PageTemplateCreate', 'PageTemplateUpdate'],
	
	extend: "Admin.view.ux.Application"
	}
);